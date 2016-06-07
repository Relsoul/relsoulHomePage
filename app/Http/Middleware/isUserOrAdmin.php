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




class isUserOrAdmin
{
    public function handle($request,$next,$id){
        $user=$request->users;
        $userName=$user->name;
        $findUser=User::where("name",$userName)->first();
        if($findUser->role>=10){
            return $next($request);
        }else{
            if($id){
                if($findUser->id!=$id){
                    return response()->json(["type"=>"false","message"=>"非用户本身","code"=>"40010"]);
                }
                return $next($request);
            }
            return response()->json(["type"=>"false","message"=>"用户权限不足","code"=>"40010"]);
        }
    }
}