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

class adminHome extends  Controller
{


    public function getAboutMe(Request $request){
        $data=Home::select('option_name', 'option_value')
            ->orWhere("option_name","name")
            ->orWhere("option_name","age")
            ->orWhere("option_name","website")
            ->orWhere("option_name","email")
            ->groupBy("option_name")
            ->get();
        $aboutMe=[];
        foreach ($data as $key=>$val){
            $aboutMe[$val->option_name]=$val->option_value;
        }

        return response()->json(["type"=>"true","message"=>"登录成功","result"=>$aboutMe]);

    }

    public function updateAboutMe(Request $request){


    }



}