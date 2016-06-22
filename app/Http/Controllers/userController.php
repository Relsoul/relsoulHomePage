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

//这里可以使用app_path来替换目录..
define("geePath",realpath(__DIR__."/../../../vendor/gee-team/gt-php-sdk/"));

require_once (geePath."/lib/class.geetestlib.php");
require_once (geePath."/config/config.php");

class userController extends Controller
{

    public function register(Request $request){
        $userName=trim($request->input("name"));
        $userPassword=trim($request->input("password"));
        $email=trim($request->input("email"));

        //判断是否获取到用户参数
        if(!$userName||!$userPassword||!$email){
            return response()->json(["type"=>"false","message"=>"注册失败,请填写好完整表单","code"=>"40005"]);
        }

        //判断用户email是否正确
        if(!preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/',$email)){
            return response()->json(["type"=>"false","message"=>"注册失败,email格式不正确","code"=>"40005"]);
        }

        $userPassword=Crypt::encrypt($userPassword);

        //数据库错误捕获在Exceptions
        $done=DB::insert("insert into users(id,name,email,password,created_at,updated_at) VALUES (?,?,?,?,?)",[NULL,$userName,$email,$userPassword,time(),time()]);
        if(!$done){
            return response()->json(["type"=>"false","message"=>"注册失败","code"=>"40006"]);
        }
        return response()->json(["type"=>"true","message"=>"注册成功","result"=>$userName]);
    }

    private function validateUser($login,$logintype,$password,$usersModel){
        if($logintype=1){
            $user=$usersModel->where("name","=",$login)->get();
            if(!$user){
                return response()->json(["type"=>"false","message"=>"用户不存在","code"=>"40003"]);
            }
            if(Crypt::decrypt($user[0]->password)==$password){
                $key=config("app.jwt");
                $exp=config("app.jwtTime");
                $token=JWT::encode(["name"=>$user[0]->name,"createTime"=>time(),"id"=>$user[0]->id,"tokenExp"=>time()+$exp],$key);
                //session(["token"=>$token]);
                return response()->json(["type"=>"true","message"=>"登录成功","result"=>["token"=>$token,"userName"=>$user[0]->name]]);
            }
            return  response()->json(["type"=>"true","message"=>"密码不正确","code"=>"40003"]);
        }else{

        }
    }

    public function login(Request $request){
        //dd($request->session()->get("testValidate"));
        $login=$request->input("name");
        $logintype=$request->input("loginType");
        $password=$request->input("password");
        $usersModel=DB::table("users");
       // dd($usersModel->get());
        $GtSdk = new \GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
        $status=session('gtserver');
        $userID =session('user_id');

        $geetestChallenge=$request->input("geetest_challenge");
        $geetestValidate=$request->input("geetest_validate");
        $geetestSeccode=$request->input("geetest_seccode");
        //dd($geetestChallenge,$geetestValidate,$geetestSeccode,$login,$logintype,$password,$userID);

        return $this->validateUser($login,$logintype,$password,$usersModel);
/*        if ($status == 1) {
            $result = $GtSdk->success_validate($geetestChallenge, $geetestValidate, $geetestSeccode,$userID);
            if ($result) {
                return $this->validateUser($login,$logintype,$password,$usersModel);
            } else{
                return response()->json(["type"=>"false","message"=>"验证码不正确","code"=>"40004"]);
            }
        }else{
            if ($GtSdk->fail_validate($geetestChallenge,$geetestValidate,$geetestSeccode)) {
                return $this->validateUser($login,$logintype,$password,$usersModel);
            }else{
                return response()->json(["type"=>"false","message"=>"验证码不正确","code"=>"40004"]);
            }
        }*/
    }


    /*
     *
     * 验证
     * */

    public function initGeeTest(Request $request){
        $GtSdk = new \GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
        $status=$GtSdk->pre_process();
        session(['gtserver' => $status]);
        session(['user_id' => "testId"]);
        $result=$GtSdk->get_response_str();
        return response()->json(["type"=>"true","message"=>"获取验证码","result"=>json_decode($result)]);
    }

    public function me(Request $request){
        $name=$request->users->name;
  
        $userInfo=DB::table("users")->where("name",$name)->first();
        if(empty($userInfo)){
            return response()->json(["type"=>"false","message"=>"token无效或过期,用户获取失败","code"=>"40007"]);
        }

        return response()->json(["type"=>"true","message"=>"获取权限成功","result"=>["role"=>$userInfo->role,"id"=>$userInfo->id]]);
    }





}