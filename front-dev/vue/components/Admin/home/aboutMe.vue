<template>
    <div class="row">
        <p class="info-text">{{msg}}</p>
        <form class="col s12" enctype="multipart/form-data">
            <div class="input-field col m6">
                <input placeholder="Placeholder" id="admin-home-name" type="text" v-model="aboutMeName" class="validate">
                <label for="admin-home-name">姓名</label>
            </div>
            <div class="input-field col m6">
                <input placeholder="Placeholder" id="admin-home-age" type="number" v-model="aboutMeAge" class="validate">
                <label for="admin-home-age">年龄</label>
            </div>
            <div class="input-field col m6">
                <input placeholder="Placeholder" id="admin-home-email" type="email" v-model="aboutMeEmail" class="validate">
                <label for="admin-home-email">邮箱</label>
            </div>
            <div class="input-field col m6">
                <input placeholder="Placeholder" id="admin-home-website"  type="url" v-model="aboutMeUrl" class="validate">
                <label for="admin-home-website">网址</label>
            </div>
            <div class="file-field input-field col m12">
                <input class="file-path validate col m6" type="text"  />
                <div class="btn">
                    <span>File</span>
                    <input type="file" @change="aboutMeUpload($event,'aboutMeImgFile','aboutMeImg')" />
                </div>
            </div>
            <div class="col m12">
                <img :src="aboutMeImg"  class="responsive-img" alt="">
            </div>
        </form>
        <div class="row">
            <button class="btn col m3 offset-m2 s12 " @click="updateAboutMe($event,'aboutMeImgFile')">保存</button>
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
                aboutMeImg:"",
                aboutMeName:"",
                aboutMeAge:"",
                aboutMeEmail:"",
                aboutMeUrl:"",
                aboutMeImgFile:"",
                aboutMeInfo:"",
            }
        },
        methods:{
            aboutMeUpload(e,imgFile,imgElem){
                //非按值传递
                let target=e.target;
                let file=target.files[0];
                let reader=new FileReader();

                if(/image/.test(file.type)){
                    reader.readAsDataURL(file)
                }

                reader.onload=()=>{
                    this[imgElem]=reader.result;
                    //$(target).parent().append(`<img src="${reader.result}">`);
                };

                let f=new FormData();
                f.append("file",target.files[0]);
                this[imgFile]=target.files[0];

                console.log(f);
                console.log("event",e);
                console.log("文件对象",target.files[0]);

            },
            updateAboutMe(e){
                e.stopImmediatePropagation();
                e.preventDefault();

                let f=new FormData();
                f.append("name",this.aboutMeName);
                f.append("email",this.aboutMeEmail);
                f.append("age",this.aboutMeAge);
                f.append("img",this.aboutMeImgFile);
                f.append("website",this.aboutMeUrl);
                $.tokenAjax("/admin/home/aboutme","post",f).then((data)=>{
                    this.showInfo(data.message,2000,"aboutMeInfo");
                }).catch()
            },
            showInfo:showInfo()
        },
        ready(){
            $.promiseAjax("/home/aboutme","get").then((data)=>{
                let result=data.result;
                this.aboutMeName=data.result["name"]||"";
                this.aboutMeAge=data.result["age"]||0;
                this.aboutMeEmail=data.result["email"]||"";
                this.aboutMeUrl=data.result["website"]||"";
                this.aboutMeImg=data.result["imgurl"]||"";
                console.log("aboutme",data);
                this.showInfo(data.message,2000,"msg")
        }).catch(

            )
        },
        components:{

        }
    }
</script>