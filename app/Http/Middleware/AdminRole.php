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
use App\Models\User;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;




class AdminRole
{
    public function handle($request,$next){
        $user=$request->users;
        $userName=$user->name;
        $findUser=User::where("name",$userName)->first();
        if($findUser->role>=10){
            return $next($request);
        }else{
            return response()->json(["type"=>"false","message"=>"用户权限不足","code"=>"40010"]);
        }
    }
}