<template>
   <div class="project-edit">
       <div class="row">
           <div class="col s10 m10 offset-s1 offset-m1">
               <div class="row">
                   <p>{{msg}}</p>
                   <ul class="collapsible popout" data-collapsible="accordion">
                       <li class="col s6 m6">
                               <div class="collapsible-header"><i class="mdi-image-filter-drama"></i>图片列表</div>
                               <div class="collapsible-body">
                                   <ul class="collection">
                                       <li class="collection-item image-list-item" v-for="img in imgs">
                                           <img class="image-list-item-img" src="" :src="img.url" alt="" :data-id="img.Id">
                                           <button class="btn image-list-item-btn" @click="insertImg($event,img.url)" >点击插入文章</button>
                                           <button class="btn image-list-item-btn" @click="deleteImg($event,img,img.Id)">删除图片</button>
                                           <button class="btn image-list-item-btn " :class="img.url==cover?'tooltipped':''" data-position="top" data-delay="50" data-tooltip="封面图片" @click="setCover($event,img.url)">设置封面</button>
                                       </li>
                                   </ul>
                               </div>
                       </li>
                   </ul>
                   <div class="col s4 m4 img-upload-box" style="padding-left:20px;">
                       <div class="file-field input-field project-file-upload">
                           <div class="btn">
                               <span>图片上传</span>
                               <input type="file" @change="uploadProjectImg($event)">
                           </div>
                           <div class="file-path-wrapper">
                               <input class="file-path validate" type="text">
                           </div>
                       </div>
                       <div class="row">
                           <div class="col s4 m4">
                               <img class="img-preview" src="" :src="preview" alt="" >
                           </div>
                       </div>
                   </div>
               </div>
               <div class="row">
                   <div class="row">
                       <div class="input-field col s10">
                           <input v-model="title" id="first_name2" type="text" class="validate">
                           <label class="active" for="first_name2">标题</label>
                       </div>
                       <button class="btn right project-save-btn" @click="saveContent($event)">保存</button>
                       <div class="row">
                           <div class="col s12">
                               <input type="checkbox" class="filled-in" id="home-project" v-model="home_show"  />
                               <label for="home-project">是否推荐到首页</label>
                           </div>
                           <div class="input-field col s12">
                               <textarea id="summary" class="materialize-textarea" length="255" v-model="summary"></textarea>
                               <label class="active" for="summary">摘要</label>
                           </div>
                       </div>
                       <div id="editormd" class="col s12 m12" >
                           <textarea class="editormd-markdown-textarea" name="$id-markdown-doc"></textarea>
                           <!-- html textarea 需要开启配置项 saveHTMLToTextarea == true -->
                           <textarea class="editormd-html-textarea" name="$id-html-code"></textarea>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">

    import {showInfo} from "../../../service/showInfo";

    export default{
        data(){
            return{
                msg:'',
                editor:null,
                imgs:[],
                content:"",
                preview:"",
                title:"",
                home_show:false,
                summary:"",
                cover:""
            }
        },
        methods:{
            showInfo:showInfo(),
            saveContent(e){
                let id=this.$route.params.id;
                this.content=this.editor.getMarkdown();
                console.log("this.home_show",this.home_show);
                $.tokenAjax("/admin/project/"+id,"put",{title:this.title,content:this.content,cover:this.cover||" ",home_show:0+this.home_show||0,summary:this.summary})
                        .then((data)=>{
                            this.showInfo("保存成功",2000,"msg");
                        })
                        .catch();
            },
            uploadProjectImg(e){
                //非按值传递

                //获取目标对象并且渲染出file
                let target=e.target;
                let file=target.files[0];
                let reader=new FileReader();
                let id=this.$route.params.id;

                if(/image/.test(file.type)){
                    reader.readAsDataURL(file)
                }else{
                    this.showInfo("请上传图片文件",2000,"msg");
                    return false;
                }

                reader.onload=()=>{
                    this.preview=reader.result;
                };

                let uploadFile=new FormData();
                uploadFile.append("projectImg",target.files[0]);

                $.tokenAjax("/admin/project-uploadimg/"+id,"post",uploadFile)
                        .then((data)=>{
                            this.showInfo(data.message,2000,"msg");
                            this.imgs.push({Id:data.result.id,url:data.result.url});
                            this.preview="";
                        })
                        .catch((data)=>{
                            this.showInfo(data.message,2000,"msg");
                            this.preview="";
                        });
            },
            deleteImg(e,img,id){

                $.tokenAjax("/admin/project-uploadimg/"+id,"delete")
                        .then((data)=>{
                            this.showInfo(data.message,2000,"msg");
                            let index=this.imgs.indexOf(img);
                            this.imgs.splice(index,1);
                        })
                        .catch((data)=>{
                            this.showInfo(data.message,2000,"msg");
                        });
            },
            insertImg(e,url){
                this.editor.insertValue(`![图片描述](${url})`);
                this.editor.getCursor()
            },
            setCover(e,url){
                this.cover=url;
                $(event.target).parent('li').siblings().find("button").removeClass('tooltipped');
                $(".material-tooltip").remove(); //移除原小气泡提示元素
                $('.tooltipped').tooltip('remove');
                $(event.target).addClass("tooltipped");
                //重新生成小气泡提示
                $('.tooltipped').tooltip({delay: 50});
                this.saveContent();
            }
        },
        route:{
            data(){
                let id=this.$route.params.id;
                $.tokenAjax("/project/"+id,"get")
                        .then((data)=>{
                            this.title=data.result.name;
                            this.cover=data.result.cover;
                            this.content=data.result.content;
                            this.summary=data.result.summary;
                            this.home_show=data.result.home_show;
                            //this.editor.setMarkdown(this.content);
                            console.log("project-edit",data)
                        })
                        .catch();

                $.tokenAjax("/project-uploadimg/"+id,"get")
                        .then((data)=>{
                            this.imgs=data.result;
                        })
                        .catch(()=>{

                        })
            }
        },
        ready(){

            //按键保存
            $(window).on("keydown",(e)=>{
                let keyCode = e.keyCode || e.which || e.charCode;
                let ctrlKey = e.ctrlKey || e.metaKey;
                if(ctrlKey && keyCode == 83) {
                    this.saveContent();
                    return false;
                }
            });


            let screenHeight=$(document).height();

            this.editor = editormd("editormd", {
                path : "/lib/editor/module/", // Autoload modules mode, codemirror, marked... dependents libs path
                height:screenHeight-100,
                saveHTMLToTextarea : true,
                onload:function(){
                    let count=0;
                    let timer=setInterval(()=>{
                        count++;
                        //最大轮询次数
                        if(count>=5){
                            this.content=="hello world";
                        }
                        if(this.content!==""){
                            clearInterval(timer);
                            $('.tooltipped').tooltip({delay: 50});
                            this.editor.setMarkdown(this.content);
                        }
                    },1000)
                }.bind(this)
            });


            //设置下拉
            $(document).ready(function(){
                $('.collapsible').collapsible({
                    accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
                });


            });
        },
        components:{

        }
    }
</script>