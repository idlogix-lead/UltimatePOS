<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user()->business_id;
    });
    Route::post("/report/profitloss/{by?}","ApiController@ProfitLossReportBy");
    // Route::get('/reports/get-profit/{by?}', 'ApiController@getProfit');
});



Route::post("/login","ApiController@login");
