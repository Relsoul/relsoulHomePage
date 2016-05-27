<?php
/**
 * Created by PhpStorm.
 * User: soul
 * Date: 2016/5/18
 * Time: 22:14
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;

class adminController extends Controller
{
    public function users(Request $request){
        return response()->json(["type"=>"true","message"=>"管理页面登录成功"]);
    }

    public function me(Request $request){
        $name=$request->users->name;

        $userInfo=User::where("name",$name)->get();
        if(!$userInfo){
            return response()->json(["type"=>"false","message"=>"token无效或过期,用户获取失败","code"=>"40007"]);
        }

        return response()->json(["type"=>"true","message"=>"获取权限成功","result"=>["role"=>$userInfo[0]->role]]);
    }
    

}