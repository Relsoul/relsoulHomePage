<?php
/**
 * Created by PhpStorm.
 * User: soul
 * Date: 2016/5/18
 * Time: 21:28
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Crypt;
use JWT;

class userController extends Controller
{

    public function register(Request $request){
        $userName=$request->input("name");
        $userPassword=$request->input("password");
        $email=$request->input("email");
        $userPassword=Crypt::encrypt($userPassword);


        $done=DB::insert("insert into users(id,name,email,password) VALUES (?,?,?,?)",[NULL,$userName,$email,$userPassword]);
        if(!$done){
            return response()->json(["type"=>"false","message"=>"注册失败"]);
        }
        return response()->json(["type"=>"true","message"=>"注册成功","result"=>$userName]);
    }

    public function login(Request $request){
        $login=$request->input("name");
        $logintype=$request->input("loginType");
        $password=$request->input("password");
        $usersModel=DB::table("users");
       // dd($usersModel->get());
        if($logintype=1){
            $user=$usersModel->where("name","=",$login)->get();
            if(!$user){
                return response()->json(["type"=>"false","message"=>"用户不存在"]);
            }
            if(Crypt::decrypt($user[0]->password)==$password){
                $key=config("app.jwt");
                $exp=config("app.jwtTime");
                $token=JWT::encode(["name"=>$user[0]->name,"time"=>time(),"exp"=>time()+$exp],$key);
                return response()->json(["type"=>"true","message"=>"登录成功","result"=>$token]);
            }
            return  response()->json(["type"=>"true","message"=>"密码不正确"]);
        }else{

        }

    }




}