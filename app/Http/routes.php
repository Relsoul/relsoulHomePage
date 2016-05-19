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
    return view('welcome');
});
Route::get("/cc/",function(){
    return view('welcome');
});

Route::group(["middleware"=>"JWTAuthToken","prefix"=>"admin"],function(){
    Route::get("users","adminController@users");
});

Route::post("/login","userController@login");
Route::post("/register","userController@register");