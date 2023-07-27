<?php

use Illuminate\Http\Request;
use App\User;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/login",function(Request $request){
    $data = $request->validate([
        "username" => "required",
        "password" => "required",
    ]);

    $user = User::where("username",$data['username'])->first();
    
    // return $user->createToken("auth_token")->accessToken;
    return $user;
});
