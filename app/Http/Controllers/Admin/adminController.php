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

class adminController extends Controller
{
    public function users(Request $request){
        return response()->json(["type"=>"true","message"=>"管理页面登录成功"]);
    }
    

}