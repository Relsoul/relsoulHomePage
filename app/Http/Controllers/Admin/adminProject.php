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
            $data=DB::table("project")->select("id","title as name","content","cover","imgs","summary","home_show","start_time","end_time")->where("id",$id)->first();
            if(empty($data)){
                return response()->json(["type"=>"false","message"=>"项目不存在","code"=>"40009"]);
            }
            return response()->json(["type"=>"true","message"=>"获取项目成功","result"=>$data]);
        }

        //如果id不存在则通过分页获取所有项目
        if(empty($id)){
            $page=(int) $request->input("page");
            //如果page参数存在
            if(!empty($page)){
                $limit=--$page*10;
                //分页获取项目
                $data=DB::table("project")->select("id","title as name","content","cover","imgs")->skip($limit)->take(10)->get();
                $dataLength=DB::table("project")->count();

                return response()->json(["type"=>"true","message"=>"获取分页项目成功","result"=>["userList"=>$data,"count"=>$dataLength]]);

                //如果不存在id也不存在page参数则返回错误
            }else{
                return response()->json(["type"=>"false","message"=>"参数不正确,page参数必须存在","code"=>"40009"]);
            }
        }
    }

    public function getHomeShowProject(){
        $data=DB::table("project")->where("home_show",1)->get();
        return response()->json(["type"=>"true","message"=>"获取Home_show项目成功","result"=>$data]);

    }

    public function searchProject(Request $request){
        $s=$request->input("s");
        $page=(int) $request->input("page");

        //page与s必须存在
        if(!empty($page)&&!empty($s)){
            $limit=--$page*10;
            //分页获取项目
            $data=DB::table("project")->select("id","title as name","content","cover","imgs")->where("title","like","%".$s."%")->skip($limit)->take(10)->get();
            $dataLength=DB::table("project")->where("title","like","%".$s."%")->count();

            return response()->json(["type"=>"true","message"=>"搜索项目成功","result"=>["userList"=>$data,"count"=>$dataLength]]);

            //如果不存在s或者page参数则返回错误
        }else{
            return response()->json(["type"=>"false","message"=>"参数不正确,page参数必须存在","code"=>"40009"]);
        }





    }

    public function updateProject(Request $request,$id=null){
        //更新必须提供id参数
        if(empty($id)){
            return response()->json(["type"=>"false","message"=>"更新必须提供id参数","code"=>"40009"]);
        }

        //如果存在id参数则进行更新
        if(!empty($id)){
            $title=$request->input("title");
            $content=$request->input("content");
            $cover=$request->input("cover");
            $home_show=(int) $request->input("home_show");
            $summary=$request->input("summary");
            $start_time=$request->input("start_time");
            $end_time=$request->input("end_time");

            //预先查找是否存在id项目
            $isData=DB::table("project")->where("id",$id)->first();

            //如果不存在该id项目则返回..这种情况都非法提交.
            if(empty($isData)){
                return response()->json(["type"=>"false","message"=>"非法提交id参数","code"=>"40009"]);
            }

            //构建数组进行填充.
            $updateArr=["title"=>$title,"content"=>$content,"cover"=>$cover?$cover:" ","home_show"=>$home_show?$home_show:0,"summary"=>$summary?$summary:"项目未描述","start_time"=>$start_time?$start_time:"2016-07-01","end_time"=>$end_time?$end_time:"2016-07-02"];

            $data=DB::table('project')
                ->where('id', $id)
                ->update($updateArr);

            if(empty($data)){
                return response()->json(["type"=>"false","message"=>"更新失败,某些参数不正确","code"=>"40009"]);
            }

            return response()->json(["type"=>"true","message"=>"更新成功","result"=>$data]);
        }

        return response()->json(["type"=>"false","message"=>"请提供正确的参数","code"=>"40009"]);


    }

    public function deleteProject(Request $request,$id=null){

        //删除必须提供id参数
        if(empty($id)){
            return response()->json(["type"=>"false","message"=>"删除必须提供id参数","code"=>"40009"]);
        }

        if(!empty($id)){
            //预先查找是否存在项目
            $isExist=DB::table("project")->where("id",$id)->first();
            if(empty($isExist)){
                return response()->json(["type"=>"false","message"=>"项目不存在","code"=>"40009"]);
            }

            //删除项目
            $deleteUser=DB::table("project")->where("id",$id)->delete();
            return response()->json(["type"=>"true","message"=>"删除成功","result"=>$deleteUser]);
        }


        return response()->json(["type"=>"false","message"=>"请提供正确的参数","code"=>"40009"]);

    }

    public function newProject(Request $request){
        //因为要预先知道文章id才能进行imgupload,那么点击new则是新建一个文章
        $newProjectId = DB::table('project')->insertGetId(
            ['title' => '命名你的项目', 'content' => "hello world",'created_at'=>time(),'updated_at'=>time()]
        );

        return response()->json(["type"=>"true","message"=>"更新成功","result"=>["id"=>$newProjectId]]);

    }

    public function getProjectImg(Request $request,$projectID=null){
        if(empty($projectID)){
            return response()->json(["type"=>"false","message"=>"获取图片必须有projectId","code"=>"40009"]);
        }
        $data=DB::table("project_img")->where("project_id",$projectID)->get();
        return response()->json(["type"=>"true","message"=>"获取图片成功","result"=>$data]);
    }


    public function deleteProjectImg(Request $request,$imgID=null){
        if(empty($imgID)){
            return response()->json(["type"=>"false","message"=>"删除图片必须有imgId","code"=>"40009"]);
        }
        //预先查找是否存在项目
        $isExist=DB::table("project_img")->where("id",$imgID)->first();
        if(empty($isExist)){
            return response()->json(["type"=>"false","message"=>"图片不存在","code"=>"40009"]);
        }

        $delete=DB::table("project_img")->where("id",$imgID)->delete();

        return response()->json(["type"=>"true","message"=>"删除成功","result"=>$delete]);
    }

    public function uploadProjectImg(Request $request,$projectID=null){
        $projectImg=$request->file("projectImg");

        if(empty($projectID)){
            return response()->json(["type"=>"false","message"=>"上传图片必须有projectId","code"=>"40009"]);
        }

        if ($request->hasFile("projectImg")&&$projectImg->isValid()) {
            $clientName = $projectImg->getClientOriginalName();
            $tmpName = $projectImg->getFileName();//缓存文件名
            $realPath = $projectImg->getRealPath();//真实路径
            $ext = $projectImg->getClientOriginalExtension();//后缀名
            $mimeTyoe = $projectImg->getMimeType();//mimeType
            $newName = md5(time() . $clientName) . "." . $ext;//重命名
            //realpath(__DIR__."/../../../vendor/gee-team/gt-php-sdk/")

            $projectImgDir=app_path(). '/../public/storage/uploads/project/'.$projectID;
            $dir_exists=file_exists($projectImgDir);
            //如果不存在项目ID的文件夹则创建一个新的文件夹.
            if(!$dir_exists){
                mkdir($projectImgDir);
            }

            $path = $projectImg->move($projectImgDir, $newName);//移动文件
            //开发环境要把app.url换成url

            //获取文件httpUrl
            $host = config("app.url");
            $projectImgUrl = $host .'/storage/uploads/project/'.$projectID."/".$newName;

            //把新图像插入项目project_img数据库中

            $project=DB::table("project")->select("imgs")->where("id",$projectID)->first();


            if(empty($project)){
                return response()->json(["type"=>"false","message"=>"项目不存在","code"=>"40009"]);
            }

            $newImgId=DB::table("project_img")->insertGetId(["url"=>$projectImgUrl,"project_id"=>$projectID]);

            return response()->json(["type"=>"true","message"=>"上传成功","result"=>["id"=>$newImgId,"url"=>$projectImgUrl]]);
        }

        return response()->json(["type"=>"false","message"=>"请上传图像文件","code"=>"40009"]);

    }



}