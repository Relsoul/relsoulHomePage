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
use Illuminate\Support\Facades\DB;

class adminUser extends Controller
{
    public function getUser(Request $request,$id=null){
        //如果存在id则获取某个用户数据
        if(!empty($id)){
            //获取全部数据,并且通过page来分页
            $data=DB::table("users")->where("id",$id)->get();
            return response()->json(["type"=>"true","message"=>"获取单个用户成功","result"=>$data]);
        }else{
            $page=(int) $request->input("page");
            if(!empty($page)){
                $limit=--$page*10;
                $data=DB::table("users")->skip($limit)->take(10)->get();
                return response()->json(["type"=>"true","message"=>"获取分页用户成功","result"=>$data]);
            }else{
                return response()->json(["type"=>"false","message"=>"请求参数不正确","code"=>"40009"]);
            }
            return response()->json(["type"=>"true","message"=>"获取所有用户成功"]);
        }
        return response()->json(["type"=>"true","message"=>"管理页面登录成功"]);
    }

    public function updateUser(Request $request,$id){
        if(!empty($id)){

        }else{

        }


        return response()->json(["type"=>"true","message"=>"获取权限成功","result"=>["role"=>$userInfo[0]->role]]);
    }

    public function newUser(Request $request){

    }

    public function deleteUser(Request $request,$id){

    }
    

}