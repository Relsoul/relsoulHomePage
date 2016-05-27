<template>
    <div class="home-aboutme">
        <div class="container">

            <div class="row">
                <div class="col m6">
                    <h3 class="text_underline">关于我</h3>
                    <p>
                        it it me
                    </p>

                    <dl class="break-dl">
                        <div class="break-list">
                            <dt>Name:</dt>
                            <dd>{{aboutMeName}}</dd>
                        </div>

                        <div class="break-list">
                            <dt>Age:</dt>
                            <dd>{{aboutMeAge}} Years</dd>
                        </div>

                        <div class="break-list">
                            <dt>Email:</dt>
                            <dd>{{aboutMeEmail}}</dd>
                        </div>

                        <div class="break-list">
                            <dt>Web:</dt>
                            <dd>{{aboutMeUrl}}</dd>
                        </div>

                    </dl>
                </div>
                <div class="col m6" style="padding: 25px">
                    <img :src="aboutMeImg" alt="" class="responsive-img">
                </div>
            </div>




        </div>
    </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">

    export default{
        data(){
            return{
                msg:'hello vue',
                aboutMeName:"",
                aboutMeAge:"",
                aboutMeEmail:"",
                aboutMeUrl:"",
                aboutMeImg:""
            }
        },
        ready(){
            $.promiseAjax("/home/aboutme","get").then((data)=>{
                let result=data.result;
                this.aboutMeName=data.result["name"]||"";
                this.aboutMeAge=data.result["age"]||0;
                this.aboutMeEmail=data.result["email"]||"";
                this.aboutMeUrl=data.result["website"]||"";
                this.aboutMeImg=data.result["imgurl"]||"";
                console.log("aboutme",data)
            }).catch(

            )
        },
        components:{

        }
    }
</script>