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
    Route::post("/report/businessprofitloss", [ApiController::class,"BusinessProfitLoss"]);
    Route::post("/report/getLocations",[ApiController::class, "GetLocations"]);
    Route::post("/report/salepurchase",[ApiController::class, "SalePurchase"]);
    // Route::get('/reports/get-profit/{by?}', 'ApiController@getProfit');
});



Route::post("/login",[ApiController::class,"login"]);
