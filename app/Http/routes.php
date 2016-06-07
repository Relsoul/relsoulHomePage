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
    //删除首页-skill
    Route::delete("home/skill","Admin\\adminHome@deleteSkill");


    //用户管理-删除用户
    Route::delete("/user/{id?}","Admin\\adminUser@deleteUser");
    //用户管理-新建用户
    Route::post("/user/","Admin\\adminUser@newUser");

});

//新分组 判断请求用户是否是本身或者具有管理权限
Route::group(["middleware"=>"JWTAuthToken"],function(){
    //用户管理-获取用户
    Route::get("/user/{id?}",["middleware"=>"isUserOrAdmin:id","uses"=>"Admin\\adminUser@getUser"]);
    //用户管理-更新用户
    Route::put("/user/{id?}",["middleware"=>"isUserOrAdmin","uses"=>"Admin\\adminUser@updateUser"]);
});



// 用户登录验证
Route::post("/login","userController@login");
Route::get("/login","userController@initGeeTest");

//用户注册
Route::post("/register","userController@register");


//获取首页-关于我
Route::get("/home/aboutme","Admin\\adminHome@getAboutMe");

//获取首页-studyExp
Route::get("/home/studyexp","Admin\\adminHome@getStudyExp");

//获取首页-skill
Route::get("/home/skill","Admin\\adminHome@getSkill");