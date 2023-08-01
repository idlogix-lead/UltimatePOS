<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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

    public function ProfitLossReport(Request $request){
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $location_id = $request->get('location_id');
        // return $request->user()->business_id;

        $data = $this->transactionUtil->getProfitLossDetails($request->user()->business_id, $location_id, $start_date, $end_date);

        $body =  view('report.partials.profit_loss_details', compact('data'))->render();
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

        $mpdf->WriteHTML($body);
        $mpdf->OutputHttpDownload('profitloss.pdf');
    }
    public function ProfitLossReportBy(Request $request,$by=null){
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $location_id = $request->get('location_id');
        // if($by =)
        $profit = ReportController::getProfit($by,$request);
        $bys = ['day',"category","brand","date",'product','customer','invoice',"location"];
        if($by != $bys[0]){
            $profit = (($profit->getData()->data)); 
            switch($by){
                case $bys[1]:
                    $profit = view('report.partials.profit_by_categories',compact("profit"))->render();
                    break;
                case $bys[2]:
                    $profit = view('report.partials.profit_by_brands',compact("profit"))->render();
                    break;
                case $bys[3]:
                    $profit = view('report.partials.profit_by_date',compact("profit"))->render();
                    break;
                case $bys[4]:
                    $profit = view('report.partials.profit_by_products',compact("profit"))->render();
                    break;
                case $bys[5]:
                    $profit = view('report.partials.profit_by_customer',compact("profit"))->render();
                    break;
                case $bys[6]:
                    $profit = view('report.partials.profit_by_invoice',compact("profit"))->render();
                    break;
                case $bys[7]:
                    $profit = view('report.partials.profit_by_locations',compact("profit"))->render();
                    break;
                default:
                    $profit = view('report.partials.profit_by_products',compact("profit"))->render();
            }
        }
        return $profit;
        // return view('report.profit_loss', compact('request'))->render();
        // $data = $this->transactionUtil->getProfitLossDetails($request->user()->business_id, $location_id, $start_date, $end_date);

        // $body =  view('report.partials.profit_loss_details', compact('data'))->render();
        // $mpdf = new Mpdf(['tempDir' => public_path('uploads/temp'), 
        //             'mode' => 'utf-8', 
        //             'autoScriptToLang' => true,
        //             'autoLangToFont' => true,
        //             'autoVietnamese' => true,
        //             'autoArabic' => true,
        //             'margin_top' => 8,
        //             'margin_bottom' => 8,
        //             'format' => 'A4'
        //         ]);

        // $mpdf->WriteHTML($body);
        // $mpdf->OutputHttpDownload('profitloss.pdf');
    }
    // public function getProfit($by=null){

    // }

    
}
