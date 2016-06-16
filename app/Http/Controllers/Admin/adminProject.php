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
        //获取某个特定项目
        if(!empty($id)){
            $data=DB::table("project")->select("id","title","content","cover","imgs")->where("id",$id)->first();
            if(empty($data)){
                return response()->json(["type"=>"false","message"=>"项目不存在","code"=>"40009"]);
            }
            return response()->json(["type"=>"true","message"=>"获取项目成功","result"=>["user"=>$data]]);
        }

        //如果id不存在则通过分页获取所有项目
        if(empty($id)){
            $page=(int) $request->input("page");
            //如果page参数存在
            if(!empty($page)){
                $limit=--$page*10;

                //分页获取项目
                $data=DB::table("project")->select("id","title","content","cover","imgs")->skip($limit)->take(10)->get();
                $dataLength=DB::table("project")->count();

                return response()->json(["type"=>"true","message"=>"获取分页用户成功","result"=>["userList"=>$data,"count"=>$dataLength]]);

                //如果不存在id也不存在page参数则返回错误
            }else{
                return response()->json(["type"=>"false","message"=>"参数不正确,page参数必须存在","code"=>"40009"]);
            }
        }
    }

    public function searchProject(Request $request){

    }

    public function updateProject(Request $request,$id=null){
        //更新必须提供id参数
        if(empty($id)){
            return response()->json(["type"=>"false","message"=>"更新必须提供id参数","code"=>"40009"]);
        }

        //如果存在id参数则进行更新
        if(!empty($id)){

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

    public function uploadProjectImg(Request $request){

    }



}