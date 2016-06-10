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
use Crypt;

class adminUser extends Controller
{
    public function getUser(Request $request,$id=null){
        //如果存在id则获取某个用户数据
        if(!empty($id)){
            //获取全部数据,并且通过page来分页
            $data=DB::table("users")->where("id",$id)->get();
            return response()->json(["type"=>"true","message"=>"获取单个用户成功","result"=>$data]);
            //不传递id则需要管理员权限
        }else if($request->userRole>=10){
            $page=(int) $request->input("page");
            $search=$request->input("s");
            if(!empty($page)){
                $limit=--$page*10;

                //如果存在分页和search参数 则认定为搜索用户的分页
                if(!empty($search)){
                    $data=DB::table("users")->where("name","like","%".$search."%")->skip($limit)->take(10)->get();
                    $dataLength=DB::table("users")->where("name","like","%".$search."%")->count();
                    $data["count"]=$dataLength;
                    return response()->json(["type"=>"true","message"=>"获取搜索用户成功","result"=>$data]);
                }

                //不搜索用户,仅仅分页
                $data=DB::table("users")->skip($limit)->take(10)->get();
                $dataLength=DB::table("users")->count();
                $data["count"]=$dataLength;




                return response()->json(["type"=>"true","message"=>"获取分页用户成功","result"=>$data]);

                //如果存在search字段则是在数据库中全部搜索
            }else if(!empty($search)){
                $data=DB::table("users")->where("name","like","%".$search."%")->get();
                $dataLength=DB::table("users")->where("name","like","%".$search."%")->count();
                $data["count"]=$dataLength;

                return response()->json(["type"=>"true","message"=>"获取搜索用户成功","result"=>$data]);
            }else{
                return response()->json(["type"=>"false","message"=>"请求参数不正确","code"=>"40009"]);
            }
        }
        return response()->json(["type"=>"true","message"=>"管理页面登录成功"]);
    }

    public function updateUser(Request $request,$id=null){
        if(!empty($id)){
            $userName=$request->input("name");
            $email=$request->input("email");
            $oldPassWord=$request->input("oldPassWord");
            $passWord=$request->input("password");
            $role=(int) $request->input("role");

            //name和email是必填项
            if(empty($userName)||empty($email)){
                return response()->json(["type"=>"false","message"=>"用户名和邮箱不能为空","code"=>"40009"]);
            }

            $updateUser=DB::table("users")->where("id",$id)->first();

            //如果数据库不存在该用户则返回
            if(empty($updateUser)){
                return response()->json(["type"=>"false","message"=>"用户不存在","code"=>"40009"]);
            }

            $newUser=DB::table("users")->where("name",$userName)->orWhere("email",$email)->get();

            //如果在插入的时候数据库已经存在了相同的name或者email则返回,大于2是排除当前用户本身
            if(count($newUser)>=2){
                return response()->json(["type"=>"false","message"=>"已有相同的用户存在,请更改email和name","code"=>"40009"]);
            }else{
                //判断查询出来的是否为用户本身
                if(count($newUser)>0){
                    if($newUser[0]->name!=$updateUser->name||$newUser[0]->email!=$updateUser->email){
                        return response()->json(["type"=>"false","message"=>"已有相同的用户存在,请更改email和name","code"=>"40009"]);
                    }
                }
                //如果没查询到用户则可以更新该id和用户名
            }


            //必填选项
            $updateArr=["name"=>$userName,"email"=>$email,"updated_at"=>time()];


            //如果用户不是管理员则需要输入原来老密码,并且不提供role权限更改功能
            if($request->userRole<10){

                if(!empty($passWord)){
                    if(Crypt::decrypt($updateUser->password)!=$oldPassWord){
                        return response()->json(["type"=>"false","message"=>"原密码不正确","code"=>"40003"]);
                    }
                    $updateArr["password"]=$passWord;
                }

                $updateUser=DB::table("users")
                    ->where("id",$id)
                    ->update($updateArr);
            }else{
                if(!empty($passWord)){
                    $updateArr["password"]=Crypt::encrypt($passWord);
                }
                $updateArr["role"]=(int)$role;
                $updateUser=DB::table("users")
                    ->where("id",$id)
                    ->update($updateArr);
            }
            return response()->json(["type"=>"true","message"=>"更新成功","result"=>$updateUser]);

        }else{
            return response()->json(["type"=>"false","message"=>"更新必须提供id参数","code"=>"40009"]);
        }

    }

    public function newUser(Request $request){
        $userName=$request->input("name");
        $email=$request->input("email");
        $passWord=$request->input("password");
        $role=(int) $request->input("role");
        //验证表单完整性
        if(empty($userName)||empty($email)||empty($passWord)||empty($role)){
            return response()->json(["type"=>"false","message"=>"请填写完整的用户提交表单","code"=>"40009"]);
        }
        $newUser=DB::table("users")->where("name",$userName)->orWhere("email",$email)->get();
        //如果通过name或者email检查到了有重复的用户则返回
        if(empty($newUser)){
            //加密后保存密码
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