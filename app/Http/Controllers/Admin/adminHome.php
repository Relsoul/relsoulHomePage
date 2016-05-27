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

class adminHome extends  Controller
{


    public function getAboutMe(Request $request){
        $data=Home::select('option_name', 'option_value')
            ->orWhere("option_name","name")
            ->orWhere("option_name","age")
            ->orWhere("option_name","website")
            ->orWhere("option_name","email")
            ->orWhere("option_name","imgurl")
            ->groupBy("option_name")
            ->get();
        $aboutMe=[];
        foreach ($data as $key=>$val){
            $aboutMe[$val->option_name]=$val->option_value;
        }

        return response()->json(["type"=>"true","message"=>"登录成功","result"=>$aboutMe]);

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

        //更新ImgUrl
        Home::where("option_name","imgurl")
            ->update(["option_value"=>$aboutMeImgUrl]);

        //更新website
        Home::where("option_name","email")
            ->update(["option_value"=>$request->email]);

        return response()->json(["type"=>"true","message"=>"更新成功","result"=>
            ["name"=>$request->name,"age"=>$request->age,"website"=>$request->website,"imgurl"=>$request->imgurl,"email"=>$request->email]
        ]);


    }



}