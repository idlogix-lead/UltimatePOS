<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\BusinessLocation;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ReportController;

use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;

class ApiController extends Controller
{
    protected $transactionUtil;
    protected $productUtil;
    protected $moduleUtil;
    protected $businessUtil;

    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil, ModuleUtil $moduleUtil, BusinessUtil $businessUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
        $this->moduleUtil = $moduleUtil;
        $this->businessUtil = $businessUtil;
    }
    static function exportToPDF($html,$title="pos_report",$format="Y-m-d"){
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
        return $mpdf->OutputHttpDownload($title.".pdf");
    }

    // get Api Access Token via login
    public function login(Request $request){
        $data = $request->validate([
            "username" => "required",
            "password" => "required|string",
        ]);
        $user = User::where("username",$data['username'])->first();
        if(isset($user) && Hash::check($data["password"],$user->password )){
            return Response::json(["auth_token"=>$user->createToken("auth_token")->accessToken],200);
        }else{
            return Response::json([
                "message" => "Invalid username or passwrod"
            ],401);
        }
    }
    //Overall business Profit Loss Report pdf
    public function BusinessProfitLoss(Request $request){
        if (! $request->user()->can('profit_loss_report.view')) {
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
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter(view('report.partials.profit_loss_details', compact('data'))->with('symbol',$request->user()->business->currency->symbol).view("report.partials.api.style")->render(),$request),"BusinessProfitLoss",$request->user()->business->date_format);

    }
    //Overall business Profit Loss Report by categories pdf 
    public function ProfitLossReportBy(Request $request,$by="product"){
        if (! $request->user()->can('profit_loss_report.view')) {
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
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter($profit,$request),"ProfitLossReport",$request->user()->business->date_format);
        
    }
    //get locations with permited locations
    public static function GetLocations(Request $request,$id = null){
        if($id !== null){
            return BusinessLocation::where('business_id', $request->user()->business_id)->where('id',$id)->where('deleted_at',null)->select(["id","business_id","location_id","name"])->first()->toArray();
        }
        return Response::json(["locations"=>BusinessLocation::where('business_id', $request->user()->business_id)->where('deleted_at',null)->select(["id","business_id","location_id","name"])->get()->toArray(),"permitted_locations"=>$request->user()->permitted_locations()],200);
    }
    //Report 2 ------------------------------------------------------------------------------
    public function SalePurchase(Request $request){
        if (! $request->user()->can('purchase_n_sell_report.view')) {
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
        // return dd($data);
        return ApiController::exportToPDF(ApiController::ApplyHeaderFooter(view('report.partials.purchase_sell')->with("api",$data)->with('symbol',$request->user()->business->currency->symbol).view("report.partials.api.style")->render(), $request),"Purchase&SellReport",$request->user()->business->date_format);
    }
    static function ApplyHeaderFooter($view,Request $request){
        $data = [
            "name" =>  $request->user()->business->name,
            "start_date" => $request->get("start_date")?$request->get("start_date"):"",
            "end_date" => $request->get("end_date")?$request->get("end_date"):"",
            "user" => $request->user()->getUserFullNameAttribute(),
            "location" => (ApiController::GetLocations($request,$request->get("location_id"))),
            "date_format" => $request->user()->business->date_format
        ];
        return view("report.partials.api.header")->with("data",$data).$view.view("report.partials.api.footer")->with("data",$request->user()->business->date_format);
    }
}
