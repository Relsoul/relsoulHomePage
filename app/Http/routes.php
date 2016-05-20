<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Http\Response;

Route::get('/', function () {
    return view('index');
});

Route::group(["middleware"=>"JWTAuthToken","prefix"=>"admin"],function(){
    Route::get("users","Admin\\adminController@users");

    //修改首页个人信息
    Route::post("home/me","Admin\\adminHome@me");
});

Route::post("/login","userController@login");
Route::post("/register","userController@register");