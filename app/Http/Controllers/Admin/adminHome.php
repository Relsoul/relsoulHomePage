<?php
/**
 * Created by PhpStorm.
 * User: soul
 * Date: 2016/5/19
 * Time: 12:32
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Home;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\homeExp;

class adminHome extends  Controller
{


    public function getAboutMe(Request $request){
        $data=Home::select('option_name', 'option_value')
            ->orWhere("option_name","name")
            ->orWhere("option_name","age")
            ->orWhere("option_name","website")
            ->orWhere("option_name","email")
            ->orWhere("option_name","imgurl")
            ->orWhere("option_name","content")
            ->groupBy("option_name")
            ->get();
        $aboutMe=[];
        //更改数据json顺序
        foreach ($data as $key=>$val){
            $aboutMe[$val->option_name]=$val->option_value;
        }

        return response()->json(["type"=>"true","message"=>"获取个人信息成功","result"=>$aboutMe]);

    }

    public function updateAboutMe(Request $request){
        $aboutMeImg=$request->file("img");
        $aboutMeImgUrl="";
        if ($request->hasFile("img")&&$aboutMeImg->isValid()) {
            $clientName=$aboutMeImg->getClientOriginalName();
            $tmpName=$aboutMeImg->getFileName();//缓存文件名
            $realPath=$aboutMeImg->getRealPath();//真实路径
            $ext=$aboutMeImg->getClientOriginalExtension();//后缀名
            $mimeTyoe=$aboutMeImg->getMimeType();//mimeType
            $newName = md5(time().$clientName).".".$ext;//重命名
            //realpath(__DIR__."/../../../vendor/gee-team/gt-php-sdk/")
            $path=$aboutMeImg->move(app_path().'/../public/storage/uploads/',$newName);//移动文件
            //开发环境要把url换成url
            $host=config("app.url");
            $aboutMeImgUrl=$host."/storage/uploads/".$newName;
            //更新ImgUrl
            Home::where("option_name","imgurl")
                ->update(["option_value"=>$aboutMeImgUrl]);
        }

        //更新name
        Home::where("option_name","name")
            ->update(["option_value"=>$request->name]);

        //更新age
        Home::where("option_name","age")
            ->update(["option_value"=>$request->age]);

        //更新website
        Home::where("option_name","website")
            ->update(["option_value"=>$request->website]);

        //更新website
        Home::where("option_name","email")
            ->update(["option_value"=>$request->email]);

        //更新content
        Home::where("option_name","content")
            ->update(["option_value"=>$request->about_content]);

        return response()->json(["type"=>"true","message"=>"更新成功","result"=>
            ["name"=>$request->name,"age"=>$request->age,"website"=>$request->website,"imgurl"=>$request->imgurl,"email"=>$request->email,"content"=>$request->about_content]
        ]);
    }

    public function getStudyExp(Request $request){
        $data=homeExp::all();
        return response()->json(["type"=>"true","message"=>"获取成功","result"=>$data]);
    }

    public function updateStudyExp(Request $request){
        $list=$request->input("list");
        dd($list);
        $data=[];
        if($list&&is_array($list)){
            foreach ($list as $key=>$value){
                //如果存在exp_id那么则判断为老数据
                if(array_key_exists("exp_id",$value)){
                    $value["exp_id"]=(int)$value["exp_id"];
                    $tryData=homeExp::where("exp_id",$value["exp_id"])->get();
                    if(!empty($tryData)){
                        homeExp::where("exp_id",$value["exp_id"])
                            ->update([
                                "exp_name"=>$value["exp_name"],
                                "exp_content"=>$value["exp_content"],
                                "exp_start_time"=>$value["exp_start_time"],
                                "exp_end_time"=>$value["exp_end_time"],
                                "exp_img"=>$value["exp_img"]?$value["exp_img"]:""
                            ]);

                    }else{
                        return response()->json(["type"=>"false","message"=>"更新失败","code"=>"40009"]);
                    }
                }else{
                    //新数据
                    $exp=homeExp::insertGetId(
                        [
                            "exp_name"=>$value["exp_name"],
                            "exp_content"=>$value["exp_content"],
                            "exp_start_time"=>$value["exp_start_time"],
                            "exp_end_time"=>$value["exp_end_time"],
                            "exp_img"=>array_key_exists("exp_img",$value)?$value["exp_img"]:""
                        ]
                    );
                   /* $exp->exp_name = $value["exp_name"];
                    $exp->exp_content=$value["exp_content"];
                    $exp->exp_start_time=$value["exp_start_time"];
                    $exp->exp_end_time=$value["exp_end_time"];
                    $exp->exp_img=array_key_exists("exp_img",$value)?$value["exp_img"]:"";
                    $newData=$exp->save();*/
                    array_push($data,$exp);
                }
            }
            return response()->json(["type"=>"true","message"=>"更新成功","result"=>$data]);
        }else{
            return response()->json(["type"=>"false","message"=>"请传递合法参数","code"=>"40009"]);
        }
        /*dd(homeExp::where("exp_name","test1")->get());*/

    }

    public function deleteStudyExp(Request $request){

        $exp_id=$request->input("exp_id");
        //是否存在$exp_id这个值
        if(empty($exp_id)){
            return response()->json(["type"=>"false","message"=>"删除失败,数据不正确","code"=>"40009"]);
        }
        $exp_id=(int) $exp_id;
        $tryData=homeExp::where("exp_id",$exp_id)->get();
        //是否存在$exp_id对应的数据
        if(!empty($tryData)){
            homeExp::where("exp_id",$exp_id)->delete();
            return response()->json(["type"=>"true","message"=>"删除成功","result"=>$tryData]);
        }else{
            return response()->json(["type"=>"false","message"=>"删除失败","code"=>"40009"]);
        }

    }

    public function getSkill(Request $request){
        $data=DB::select("SELECT * FROM skill");
        return response()->json(["type"=>"true","message"=>"获取skill成功","result"=>$data]);
    }

    public function updateSkill(Request $request){
        $list=$request->input("list");
        $data=[];
        if($list&&is_array($list)){
            foreach ($list as $key=>$value){
                //如果存在skill_id那么则判断为老数据
                if(array_key_exists("skill_id",$value)){
                    $value["skill_id"]=(int)$value["skill_id"];
                    $tryData=DB::table("skill")->where("skill_id",$value["skill_id"])->get();
                    if(!empty($tryData)){

                        $t=DB::table("skill")->where("skill_id",$value["skill_id"])
                            ->update([
                                "skill_name"=>(int)$value["skill_name"],
                                "start_exp"=>(int) $value["start_exp"],
                                "end_exp"=>(int) $value["end_exp"],
                                "updated_at"=>time()
                            ]);
                    }else{
                        return response()->json(["type"=>"false","message"=>"更新skill失败","code"=>"40009"]);
                    }
                }else{
                    //新数据
                    $exp=DB::table("skill")->insertGetId(
                        [
                            "skill_name"=>(int)$value["skill_name"],
                            "start_exp"=>(int)$value["start_exp"],
                            "end_exp"=>(int)$value["end_exp"],
                            "created_at"=>time(),
                            "updated_at"=>time()
                        ]
                    );
                    array_push($data,$exp);
                }
            }
            return response()->json(["type"=>"true","message"=>"更新skill成功","result"=>$data]);
        }else{
            return response()->json(["type"=>"false","message"=>"请传递合法参数","code"=>"40009"]);
        }
        /*dd(homeExp::where("exp_name","test1")->get());*/
    }

    public function deleteSkill(Request $request){
        $skill_id=$request->input("skill_id");
        //是否存在$skill_id这个值
        if(empty($skill_id)){
            return response()->json(["type"=>"false","message"=>"删除失败,数据不正确","code"=>"40009"]);
        }
        $skill_id=(int) $skill_id;
        $tryData=DB::table("skill")->where("skill_id",$skill_id)->get();

        //是否存在$skill_id对应的数据
        if(!empty($tryData)){
            DB::table("skill")->where("skill_id",$skill_id)->delete();
            return response()->json(["type"=>"true","message"=>"删除成功","result"=>$tryData]);
        }else{
            return response()->json(["type"=>"false","message"=>"删除失败","code"=>"40009"]);
        }
    }



}