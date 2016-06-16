<?php
/**
 * Created by PhpStorm.
 * User: soul
 * Date: 2016/6/16
 * Time: 10:34
 */


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminProject extends Controller{

    public function getProject(Request $request,$id=null){
        if(!empty($id)){

        }


    }

    public function updateProject(Request $request,$id=null){
        //更新必须提供id参数
        if(empty($id)){
            return response()->json(["type"=>"false","message"=>"更新必须提供id参数","code"=>"40009"]);
        }

    }

    public function deleteProject(Request $request,$id=null){

        //删除必须提供id参数
        if(empty($id)){
            return response()->json(["type"=>"false","message"=>"删除必须提供id参数","code"=>"40009"]);
        }

    }

    public function newProject(Request $request){



    }



}