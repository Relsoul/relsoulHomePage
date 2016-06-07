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
            DB::table("users")->where("id",$id)

        }else{
            return response()->json(["type"=>"false","message"=>"更新必须提供id参数","code"=>"40009"]);
        }

    }

    public function newUser(Request $request){
        $userName=$request->input("name");
        $email=$request->input("email");
        $passWord=$request->input("password");
        $role=(int) $request->input("role");
        if(empty($userName)||empty($email)||empty($passWord)||empty($role)){
            return response()->json(["type"=>"false","message"=>"请填写完整的用户提交表单","code"=>"40009"]);
        }
        $newUser=DB::table("users")->where("name",$userName)->orWhere("email",$userName)->get();
        if(empty($newUser)){
            $passWord=Crypt::encrypt($passWord);
            $insertUser=DB::table("users")->insert(
                ["name"=>$userName,"email"=>$email,"password"=>$passWord,"role"=>$role,"created_at"=>time(),"updated_at"=>time()]
            );
            return response()->json(["type"=>"true","message"=>"添加成功","result"=>$insertUser]);
        }else{
            return response()->json(["type"=>"false","message"=>"已有相同的用户存在","code"=>"40009"]);
        }



    }

    public function deleteUser(Request $request,$id){
        if(!empty($id)){
            //预先查找是否存在用户
            $isExist=DB::table("users")->where("id",$id)->first();
            if(empty($isExist)){
                return response()->json(["type"=>"false","message"=>"用户不存在","code"=>"40009"]);
            }
            
            //删除用户
            $deleteUser=DB::table("users")->where("id",$id)->delete();
            return response()->json(["type"=>"true","message"=>"删除成功","result"=>$deleteUser]);

        }
        return response()->json(["type"=>"false","message"=>"删除必须提供id参数","code"=>"40009"]);
    }
    

}