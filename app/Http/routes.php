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

Route::group(["middleware"=>["JWTAuthToken","AdminRole"],"prefix"=>"admin"],function(){

    //后台获取所有信息
    Route::get("users","Admin\\adminController@users");


    //获取个人信息
    Route::get("me","Admin\\adminController@me");


    //更新首页-关于我
    Route::post("home/aboutme","Admin\\adminHome@updateAboutMe");

    //更新首页-studyExp
    Route::post("home/studyexp","Admin\\adminHome@updateStudyExp");
    //删除首页-studyExp
    Route::delete("home/studyexp","Admin\\adminHome@deleteStudyExp");

    //更新首页-skill
    Route::post("/home/skill","Admin\\adminHome@updateSkill");
    //删除首页-skill
    Route::get("/home/skill","Admin\\adminHome@deleteSkill");

});



// 用户登录验证
Route::post("/login","userController@login");
Route::get("/login","userController@initGeeTest");


Route::post("/register","userController@register");


//获取首页-关于我
Route::get("/home/aboutme","Admin\\adminHome@getAboutMe");

//获取首页-studyExp
Route::get("/home/studyexp","Admin\\adminHome@getStudyExp");

//获取首页-skill
Route::get("/home/skill","Admin\\adminHome@getSkill");