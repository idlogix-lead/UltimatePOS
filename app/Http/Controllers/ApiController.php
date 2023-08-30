<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

use App\Category;
use App\Unit;
use App\Contact;
use App\User;
use App\BusinessLocation;
use App\Brands;
use App\ExpenseCategory;
use App\CustomerGroup;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExpenseController;
use DB;

use Mpdf\Mpdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\CashRegisterUtil;

class ApiController extends Controller
{
    protected $transactionUtil;
    protected $productUtil;
    protected $moduleUtil;
    protected $businessUtil;

    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil, ModuleUtil $moduleUtil, BusinessUtil $businessUtil, CashRegisterUtil $cashRegisterUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
        $this->moduleUtil = $moduleUtil;
        $this->businessUtil = $businessUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
    }
    static function exportToPDF($html,$title="pos_report",$format="Y-m-d",Request $request){
        $mpdf = new Mpdf(['tempDir' => public_path('uploads/temp'), 
            'mode' => 'utf-8', 
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'autoVietnamese' => true,
            'autoArabic' => true,
            'margin_top' => 8,
            'margin_bottom' => 8,
            'format' => 'A4'
        ]);
        $date  = date($format);
        $mpdf->SetFooter("Generated At: ".$date);
        $mpdf->WriteHTML($html);

        if(!empty($request->location_id)){
            $path = "\business_".$request->user()->business_id."\location_".$request->location_id."\user_".$request->user()->id;
            $loc = $request->location_id;
        }else{
            $path = "\business_".$request->user()->business_id."\all_locations\user_".$request->user()->id;
            $loc = "all";
        }
        $business = $request->user()->business_id;
        $user = $request->user()->id;
        $location = $loc;
        $file = $title.".pdf";
        $path = storage_path('app\api_report').$path;
        // dd(file_exists($path),$path);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $path = $path."\\".$file;
        $mpdf->OutputFile($path);
        return Response::json(["report_url" => URL::temporarySignedRoute(
            'getReport', now()->addMinutes(30), ['bus'=>$business,"loc"=>$location,'user' => $user,"file"=>$file]
        )],200); 
    }
    public function getReport($business,$location,$user,$file){
        if (!request()->hasValidSignature()) {
            abort(401);
        }
        if($location != "all"){
            $path = "\business_".$business."\location_".$location."\user_".$user;
        }else{
            $path = "\business_".$business."\all_locations\user_".$user;
        }
        $file_path = 'app\api_report'.$path."\\".$file;
        return Response::make(file_get_contents(storage_path($file_path)), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$file.'"'
        ]);
    }

    // get Api Access Token via login
    public function login(Request $request){
        $data = $request->validate([
            "username" => "required",
            "password" => "required|string",
        ]);
        $user = User::where("username",$data['username'])->first();
        if(isset($user) && Hash::check($data["password"],$user->password )){
            try{
                // Remove all expired tokens
                exec("php ../artisan passport:purge");
            }catch(\Exception $e){

            }
            return Response::json(["auth_token"=>$user->createToken("auth_token")->accessToken],200);
        }else{
            return Response::json([
                "message" => "Invalid username or passwrod"
            ],401);
        }
    }
    //Overall business Profit Loss Report pdf
    public function BusinessProfitLoss(Request $request){
        if (! ($request->user()->can('profit_loss_report.view') or $request->user()->hasPermissionTo("profit_loss_report.view","web"))) {
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $location_id = $request->get('location_id');
        $data = $this->transactionUtil->getProfitLossDetails($request->user()->business_id, $location_id, $start_date, $end_date);
        $stock_sp = (ReportController::getStockBySellingPriceApi($request,["t"=>$this->transactionUtil]));
        $data = (array_merge($data,$stock_sp));
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter(view('report.partials.profit_loss_details', compact('data'))->with('symbol',$request->user()->business->currency->symbol).view("report.partials.api.style")->render(),$request),"BusinessProfitLoss",$request->user()->business->date_format,$request);

    }
    //Overall business Profit Loss Report by categories pdf 
    public function ProfitLossReportBy(Request $request,$by="product"){
        if (! ($request->user()->can('profit_loss_report.view') or $request->user()->hasPermissionTo("profit_loss_report.view","web"))) {
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $profit = ReportController::getProfit($by,$request);
        $bys = ['day',"category","brand","date",'product','customer','invoice',"location"];
        if($by != $bys[0]){
            $profit = (($profit->getData()->data)); 
            switch($by){
                case $bys[1]:
                    $profit = view('report.partials.api.profit_by_categories',compact("profit"))->with('symbol',$request->user()->business->currency->symbol)->render();
                    break;
                case $bys[2]:
                    $profit = view('report.partials.api.profit_by_brands',compact("profit"))->with('symbol',$request->user()->business->currency->symbol)->render();
                    break;
                case $bys[3]:
                    $profit = view('report.partials.api.profit_by_date',compact("profit"))->with('symbol',$request->user()->business->currency->symbol)->render();
                    break;
                case $bys[4]:
                    $profit = view('report.partials.api.profit_by_products',compact("profit"))->with('symbol',$request->user()->business->currency->symbol)->render();
                    break;
                case $bys[5]:
                    $profit = view('report.partials.api.profit_by_customer',compact("profit"))->with('symbol',$request->user()->business->currency->symbol)->render();
                    break;
                case $bys[6]:
                    $profit = view('report.partials.api.profit_by_invoice',compact("profit"))->with('symbol',$request->user()->business->currency->symbol)->render();
                    break;
                case $bys[7]:
                    $profit = view('report.partials.api.profit_by_locations',compact("profit"))->with('symbol',$request->user()->business->currency->symbol)->render();
                    break;
                default:
                    $profit = view('report.partials.api.profit_by_products',compact("profit"))->with('symbol',$request->user()->business->currency->symbol)->render();
            }
        }else{
            $profit = $profit.view("report.partials.api.style")->with('symbol',$request->user()->business->currency->symbol);
        }
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter($profit,$request),"ProfitLossReport",$request->user()->business->date_format,$request);
        
    }
    public function ProfitLossReportCustom1(Request $request){
        if ( !($request->user()->can('profit_loss_report.view') or $request->user()->hasPermissionTo("profit_loss_report.view","web"))) {
            
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $location_id = $request->location_id?$request->location_id:null;
        $business_id = $request->user()->business_id;
        // $business_locations = BusinessLocation::forDropdown($business_id, true);
        // return dd($business_locations);
        $query = ReportController::getRevenueCustom($request);
        $revenue = $query->get() !== null?$query->get()->toArray():[];
        $filters = ["start_date" => $request->start_date ,"end_date"=>$request->end_date,"location_id"=>$location_id];
        $expenses =  $this->transactionUtil->getExpenseReport($business_id, $filters, "by_sub_category")->toArray();
        $data = $this->transactionUtil->getProfitLossDetails($business_id, $location_id, $request->start_date, $request->end_date);
        // dd($revenue);
        $discount_total = (floatVal($data["total_sell_discount"]));
        $production_cost = floatVal(isset($data["left_side_module_data"][1]["value"])?$data["left_side_module_data"][1]["value"]:0);

        $view = view('report.custom.api.profit_loss')
        ->with("discount_total",$discount_total)
        ->with("production_cost",$production_cost)
        ->with("expenses",$expenses)
        ->with('symbol',$request->user()->business->currency->symbol)
        // ->with("business_locations",$business_locations)
        ->with("revenue",$revenue)->render();
        // return $view;
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter($view,$request),"ProfitLossReportCustom",$request->user()->business->date_format,$request);

    }
    //Report 2 ------------------------------------------------------------------------------
    public function SalePurchase(Request $request){
        if (! ($request->user()->can('purchase_n_sell_report.view') or $request->user()->hasPermissionTo("purchase_n_sell_report.view","web"))) {
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $business_id = $request->user()->business_id;
        $location_id = $request->get('location_id');

        $purchase_details = $this->transactionUtil->getPurchaseTotals($business_id, $start_date, $end_date, $location_id);

        $sell_details = $this->transactionUtil->getSellTotals(
            $business_id,
            $start_date,
            $end_date,
            $location_id
        );

        $transaction_types = [
            'purchase_return', 'sell_return',
        ];

        $transaction_totals = $this->transactionUtil->getTransactionTotals(
            $business_id,
            $transaction_types,
            $start_date,
            $end_date,
            $location_id
        );

        $total_purchase_return_inc_tax = $transaction_totals['total_purchase_return_inc_tax'];
        $total_sell_return_inc_tax = $transaction_totals['total_sell_return_inc_tax'];

        $difference = [
            'total' => $sell_details['total_sell_inc_tax'] - $total_sell_return_inc_tax - ($purchase_details['total_purchase_inc_tax'] - $total_purchase_return_inc_tax),
            'due' => $sell_details['invoice_due'] - $purchase_details['purchase_due'],
        ];
        $data = ['purchase' => $purchase_details,
            'sell' => $sell_details,
            'total_purchase_return' => $total_purchase_return_inc_tax,
            'total_sell_return' => $total_sell_return_inc_tax,
            'difference' => $difference,
        ];
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter(view('report.partials.purchase_sell')->with("api",$data)->with('symbol',$request->user()->business->currency->symbol).view("report.partials.api.style")->render(), $request),"Purchase&SellReport",$request->user()->business->date_format,$request);
    }
    // public function Expense_Report(Request $request){
    //     dd("hello");
    // }
    static function ApplyHeaderFooter($view,Request $request){
        $null_location = ["name"=>"All Locations ","location_id"=>" - "];
        if(!empty($request->location_id)){
            $location = ApiController::GetLocations($request,$request->location_id);
            if($location == []){
                $msg = [
                    "message" => 'No Location found for this user with this id: '.$request->location_id."."
                ];
                print_r(json_encode($msg));
                exit;
            }
        }else{
            $location = $null_location;
        }

        $data = [
            "name" =>  $request->user()->business->name,
            "start_date" => $request->get("start_date")?$request->get("start_date"):"",
            "end_date" => $request->get("end_date")?$request->get("end_date"):"",
            "user" => $request->user()->getUserFullNameAttribute(),
            "location" => $location,
            "date_format" => $request->user()->business->date_format
        ];
        return view("report.partials.api.header")->with("data",$data).$view.view("report.partials.api.footer")->with("data",$request->user()->business->date_format);
    }
    static function headerFooterData(Request $request){
        
    }
    public function ExpenseReport(Request $request){
        if (! ($request->user()->can('expense_report.view') or $request->user()->hasPermissionTo("expense_report.view","web"))) {
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $business_id = $request->user()->business_id;
        $filters = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'location_id' => $request->location_id,
            'category' => $request->category,
        ];

        $expenses = $this->transactionUtil->getExpenseReport($business_id, $filters, "by_sub_category");
        $view =  view('report.custom.api.expense')
        ->with("expenses",$expenses)
        ->with('symbol',$request->user()->business->currency->symbol);
        if($request->category && $request->category != ""){
            $view = $view->with("cat_id",$request->category);
        }
        $view .= view("report.partials.api.style");
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter($view, $request),"ExpenseReport",$request->user()->business->date_format,$request);
    }
    public function expense_ledger_report(Request $request){
        if (! ((auth()->user()->can('all_expense.access') && auth()->user()->can('view_own_expense')) or ($request->user()->hasPermissionTo("all_expense.access","web") && $request->user()->hasPermissionTo("view_own_expense","web")))) {
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $exp = new ExpenseController($this->transactionUtil, $this->moduleUtil, $this->cashRegisterUtil);
        $expenses = $exp->expenses_list()->get();
        $view = view("expense.partials.list")->with("expenses",$expenses)->with('format',$request->user()->business->date_format)->with("symbol",$request->user()->business->currency->symbol);
        $view .= view("report.partials.api.style");
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter($view, $request),"ExpenseReport",$request->user()->business->date_format,$request);
    }
    public function product_sell_report(Request $request){
        if (! (auth()->user()->can('purchase_n_sell_report.view') or $request->user()->hasPermissionTo("purchase_n_sell_report.view","web"))) {
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $business_id = $request->user()->business_id;
        $query = ReportController::productsellreportquery($request,$business_id);
        $data = $query->get();
        $payment_types = $this->transactionUtil->payment_types(null, true, $business_id);

        $view = view("report.partials.product_sell_report_table")
        ->with('payment_types',$payment_types)
        ->with('data',$data)
        ->with('format',$request->user()->business->date_format)
        ->with("symbol",$request->user()->business->currency->symbol);
        $view .= view("report.partials.api.style");
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter($view, $request),"Product Sell Report",$request->user()->business->date_format,$request);

    }
    //get Data for Parameters functions:=================================================================================================================================================================================================================================
    public static function GetLocations(Request $request,$id = null,$op =false){
        $permitted_locations = $request->user()->web_guard_permitted_locations();
        if($id !== null){
            $Loc = BusinessLocation::where('business_id', $request->user()->business_id)->where('id',$id)->where('deleted_at',null)->select(["id","business_id","location_id","name"])->first();
            if($Loc){
                return $Loc->toArray();
            }
            return [];
        }
        $locs = ["locations"=>BusinessLocation::where('business_id', $request->user()->business_id)->where('deleted_at',null)->select(["id","business_id","location_id","name"])->get()->toArray(),"permitted_locations"=>$permitted_locations];
        if($op){
            return $locs;
        }
        return Response::json($locs,200);
    }
    public function get_expense_ledger_params(Request $request){
        $exp_categories = ExpenseCategory::GetList($request->user()->business_id);
        $contacts = ApiController::GetContacts($request,true);
        $locations = ApiController::GetLocations($request,null,true);
        $users = User::where("business_id",$request->user()->business_id)
        ->whereNull("deleted_at")->select(["id",DB::raw("CONCAT_WS(' ',surname,first_name,last_name) AS name")])->get()->toArray();
        $data = [
           "exp_categories"=>$exp_categories,
           "contacts" =>  $contacts["contacts"],
           "payment_status" =>  ['paid','due','partial'],
           "users" =>  $users,
        ];
        $data = array_merge($data,$locations);
        return Response::json($data);
    }
    public function check_validate(Request $request){
        return Response::json(true,200);
    }
    public static function GetExpenseCategories(Request $request){
        if (! ($request->user()->can('expense_report.view') or $request->user()->hasPermissionTo("expense_report.view","web"))) {
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        return Response::json(ExpenseCategory::where("business_id",$request->user()->business_id)
        ->whereNull("parent_id")
        ->whereNull("deleted_at")
        ->select(["id",'name'])
        ->get()->toArray());

    }
    static function GetContacts(Request $request,$op = false){
        if (! ((auth()->user()->can('customer.view') && auth()->user()->can('supplier.view')) or ($request->user()->hasPermissionTo("customer.view","web") && $request->user()->hasPermissionTo("supplier.view","web")))) {
            if($op){
                return ["contacts" => []];
            }
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $customers = Contact::where("business_id",$request->user()->business_id)
        ->where("contact_status","active")
        ->where("deleted_at",null)
        ->select(["id","type","name","supplier_business_name","contact_id"])
        ->get();
        $data = [
            "contacts" => $customers->toArray()
        ];
        if($op){
            return $data;
        }
        return Response::json($data,200);
    }
    static function GetCustomers(Request $request,$op = false){
        if (! (auth()->user()->can('customer.view') or $request->user()->hasPermissionTo("customer.view","web"))) {
            if($op){
                return ["customers" => []];
            }
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $customers = Contact::where("business_id",$request->user()->business_id)
        ->whereIn("type",["customer","both"])
        ->where("contact_status","active")
        ->where("deleted_at",null)
        ->select(["id","name","supplier_business_name","contact_id"])
        ->get();
        $data = [
            "customers" => $customers->toArray()
        ];
        if($op){
            return $data;
        }
        return Response::json($data,200);
    }
    
    static function GetSuppliers(Request $request,$op = false){
        if (! (auth()->user()->can('supplier.view') or $request->user()->hasPermissionTo("supplier.view","web"))) {
            if($op){
                return ["suppliers" => []];
            }
            return Response::json([
                "message" => "Unauthorized action."
            ],403);
        }
        $customers = Contact::where("business_id",$request->user()->business_id)
        ->whereIn("type",["supplier","both"])
        ->where("contact_status","active")
        ->where("deleted_at",null)
        ->select(["id","name","supplier_business_name","contact_id"])
        ->get();
        $data = [
            "suppliers" => $customers->toArray()
        ];
        if($op){
            return $data;
        }
        return Response::json($data,200);
    }
    static function GetDetails(Request $request){
        $business_id = $request->user()->business_id;
        $categories = Category::GetList($business_id);
        $brands = Brands::GetList($business_id);
        $units = Unit::where('business_id', $business_id)
                ->select(['id',"actual_name",'short_name'])->get()->toArray();
        return Response::json(["units"=>$units,"brands"=>$brands,"categories"=>$categories],200);
    }
    public function get_product_sell_report_params(Request $request){
        $business_id = $request->user()->business_id;
        $locations = ApiController::GetLocations($request,null,true);
        $contacts = ApiController::GetCustomers($request,true);
        $categories = Category::GetList($business_id);
        $brands = Brands::GetList($business_id);
        $customer_groups = CustomerGroup::where('business_id', $business_id)->select('name', 'id')->get();
        $data = [
            "locations" => $locations,
            "contacts" => $contacts,
            "categories" => $categories,
            "brands" => $brands,
            "customer_groups" => $customer_groups,
        ];
        return Response::json($data,200);
    }
    public function search_product(Request $request){
        return PurchaseController::search_product();
    }
}
