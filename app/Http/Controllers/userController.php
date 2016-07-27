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
use Mail;
use Gregwar\Captcha\CaptchaBuilder;


class userController extends Controller
{

    public function register(Request $request)
    {
        $userName = trim($request->input("name"));
        $userPassword = trim($request->input("password"));
        $email = trim($request->input("email"));

        //判断是否获取到用户参数
        if (!$userName || !$userPassword || !$email) {
            return response()->json(["type" => "false", "message" => "注册失败,请填写好完整表单", "code" => "40005"]);
        }

        //判断用户email是否正确
        if (!preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/', $email)) {
            return response()->json(["type" => "false", "message" => "注册失败,email格式不正确", "code" => "40005"]);
        }

        $userPassword = Crypt::encrypt($userPassword);

        //数据库错误捕获在Exceptions
        $done = DB::insert("insert into users(id,name,email,password,created_at,updated_at) VALUES (?,?,?,?,?,?)", [NULL, $userName, $email, $userPassword, time(), time()]);
        if (!$done) {
            return response()->json(["type" => "false", "message" => "注册失败", "code" => "40006"]);
        }
        return response()->json(["type" => "true", "message" => "注册成功", "result" => $userName]);
    }

    private function clearCode()
    {
        $sessionCode = session('loginCode');
        if ($sessionCode) {
            session(['loginCode' => ""]);
        }
    }

    private function validateUser($login, $logintype, $password, $usersModel)
    {
        if ($logintype == 1) {
            $user = $usersModel->where("name", "=", $login)->get();
        } else {
            $user = $usersModel->where("email", "=", $login)->get();
        }
        if (!$user) {
            $this->clearCode();
            return response()->json(["type" => "false", "message" => "用户不存在", "code" => "40003"]);
        }
        if (Crypt::decrypt($user[0]->password) == $password) {
            $key = config("app.jwt");
            $exp = config("app.jwtTime");
            $token = JWT::encode(["name" => $user[0]->name, "createTime" => time(), "id" => $user[0]->id, "tokenExp" => time() + $exp], $key);
            //session(["token"=>$token]);
            return response()->json(["type" => "true", "message" => "登录成功", "result" => ["token" => $token, "userName" => $user[0]->name]]);
        }
        $this->clearCode();
        return response()->json(["type" => "false", "message" => "密码不正确", "code" => "40003"]);
    }

    public function login(Request $request)
    {
        $login = $request->input("name");
        $logintype = $request->input("loginType");
        $password = $request->input("password");
        $loginCode = $request->input("code");
        $usersModel = DB::table("users");
        $code = session("loginCode");

        if ($loginCode != $code) {
            $this->clearCode();
            return response()->json(["type" => "false", "message" => "验证码不正确", "code" => "40004"]);
        }

        return $this->validateUser($login, $logintype, $password, $usersModel);

    }


    /*
     *
     * 验证
     * */

    public function initGeeTest(Request $request)
    {
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        Session(['loginCode' => $phrase]);

        $dataImg = $builder->inline();
        return response()->json(["type" => "true", "message" => "获取验证码", "result" => $dataImg]);
    }

    public function me(Request $request)
    {
        $name = $request->users->name;

        $userInfo = DB::table("users")->where("name", $name)->first();
        if (empty($userInfo)) {
            return response()->json(["type" => "false", "message" => "token无效或过期,用户获取失败", "code" => "40007"]);
        }

        return response()->json(["type" => "true", "message" => "获取权限成功", "result" => ["role" => $userInfo->role, "id" => $userInfo->id]]);
    }

    /*
     *
     * 忘记密码
     *
     * */

    public function fetchPassWord(Request $request)
    {
        $email = $request->input("email");
        $user = DB::table("users")->where("email", $email)->first();

        if (empty($user)) {
            return response()->json(["type" => "false", "message" => "未检测到该邮箱对应的ID,请输入正确的邮箱地址", "code" => ""]);
        }
        $dePassword = Crypt::decrypt($user->password);

        $sender = Mail::send("emails.fetch-pass-word", ["email" => $email, "password" => $dePassword, "name" => $user->name], function ($message) use ($email) {
            $message->to($email)->subject("找回密码");
        });

        if ($sender) {
            return response()->json(["type" => "true", "message" => "系统已经发送一封邮件到您的邮箱,如未检测到请查看垃圾箱"]);
        } else {
            return response()->json(["type" => "false", "message" => "发送失败,请重新填写发送"]);
        }

    }


}