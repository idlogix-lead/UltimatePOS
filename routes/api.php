<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user()->business_id;
    });
    Route::post("/report/profitloss/{by?}", [ApiController::class,"ProfitLossReportBy"]);
    Route::post("/report/profitlosscustom1", [ApiController::class,"ProfitLossReportCustom1"]);
    Route::post("/report/businessprofitloss", [ApiController::class,"BusinessProfitLoss"]);
    Route::post("/report/salepurchase",[ApiController::class, "SalePurchase"]);
    Route::post("/report/expense_overall",[ApiController::class, "ExpenseReport"]);
    Route::post("/report/product_sell_report",[ApiController::class, "product_sell_report"]);
    Route::post("/report/stock_report",[ApiController::class, "stock_report"]);
    // --------------------------------------------------------------------
    Route::post("/report/expense_ledger",[ApiController::class, "expense_ledger_report"]);
    Route::post("/report/register_report",[ApiController::class, "register_report"]);
    Route::post("/report/register_details",[ApiController::class, "register_details"]);
    Route::post("/ledger/customer_summary",[ApiController::class, "customer_summary"]);
    // Route::get('/reports/get-profit/{by?}', 'ApiController@getProfit');
    Route::post("/getLocations",[ApiController::class, "GetLocations"]);
    Route::post("/getCustomers",[ApiController::class, "GetCustomers"]);
    Route::post("/getSuppliers",[ApiController::class, "GetSuppliers"]);
    Route::post("/getDetails",[ApiController::class, "GetDetails"]);
    Route::post("/getExpenseCategories",[ApiController::class, "GetExpenseCategories"]);
    Route::post("/get_expense_ledger_params",[ApiController::class, "get_expense_ledger_params"]);
    Route::post("/get_product_sell_report_params",[ApiController::class, "get_product_sell_report_params"]);
    Route::post("/validate",[ApiController::class, "check_validate"]);
    Route::post("/search_product",[ApiController::class, "search_product"]);
    // Route::post("/getExpenseCategories",[ApiController::class, "GetExpenseCategories"]);
});

Route::get("/get_report/{bus}/{loc}/{user}/{file}",[ApiController::class,"getReport"])->name("getReport");

Route::post("/login",[ApiController::class,"login"]);
