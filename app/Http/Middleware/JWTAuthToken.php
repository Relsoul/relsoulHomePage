<?php
/**
 * Created by PhpStorm.
 * User: soul
 * Date: 2016/5/18
 * Time: 18:41
 */

namespace App\Http\Middleware;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use JWTAuth;
use Mockery\CountValidator\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTFactory;
use JWT;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;




class JWTAuthToken
{
    public function handle($request,$next){

        //return response()->json(["status"=>"404","message"=>$tokens,"code"=>"40402"]);
        $authorization=$request->headers->get("authorization");
        if(!$authorization||$authorization!=session("token")){
            return response()->json(["type"=>"false","message"=>"token不存在","code"=>"40002"]);
        }
        //捕捉不到错误,在服务层错误进行处理
        $users=JWT::decode($authorization,config("app.jwt"),['HS256']);
        if($users->exp<=time()){
            return  response()->json(["type"=>"false","message"=>"token已经过期,请重新登陆","code"=>"40001"]);
        }
        $request->users=$users;
        return $next($request);
    }
}