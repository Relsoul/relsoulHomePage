<?php
namespace App\Exceptions;

use Illuminate\Http\Response;

class databaseError{

    public function error23000(){
        return  response()->json(["type"=>"false","message"=>"用户名/邮件名已经存在"]);
    }

    static  function send(&$e){
        $obj=new self();
        $code=$e->errorInfo[0];
        $func="error".$code;
        if(!method_exists($obj,$func)){
            return response()->json(["type"=>"false","message"=>"发生了一点小问题"]);
        }
        return $obj->$func($e);



    }
}