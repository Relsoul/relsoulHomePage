<template>
    <div :id="registerId" class="modal register-modal">
        <div class="modal-content">
            <div class="container">
                <div class="row">
                    <h4>注册</h4>
                    <p class="info-text">{{fromInfo}}</p>
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix"></i>
                                <input id="registerUser" type="text" class="validate" v-model="registerUser"  required>
                                <label for="registerUser">用户名</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix"></i>
                                <input id="registerEmail" type="email" class="validate" v-model="registerEmail" required>
                                <label for="registerEmail">邮箱</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix"></i>
                                <input id="registerPw" type="password" class="validate" v-model="registerPw" placeholder="大于6位非纯数字密码" required>
                                <label for="registerPw">密码</label>
                            </div>
                            <div class="row">
                                <button class="btn col m3 offset-m2 s12 register-btn" @click="registerClick" >注册</button>
                                <button class="btn col m3 offset-m1 s12 ">随便看看</button>
                            </div>
                        </div>
                    </form>

                    <div class="modal-footer">
                        <p>已有账号?来登陆吧</p>
                        <button :data-target="loginId" class="modal-close btn btn-flat left modal-trigger">登陆</button>
                        <a href="#" class="btn modal-action modal-close waves-effect waves-green btn-flat">close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">
    import {showInfo} from "../service/showInfo"

    export default{
        data(){
            return{
                msg:'hello vue',
                registerUser:"",
                registerEmail:"",
                registerPw:"",
                fromInfo:""
            }
        },
        ready(){
            $(".modal-trigger").leanModal();
        },
        methods:{
            registerClick(e){
                if(this.registerUser&&this.registerEmail&&this.registerPw){
                    if(/\s+/gi.test(this.registerUser)){
                        this.showInfo("请不要再用户名中包含空格哦~",2000,"fromInfo");
                        return false;
                    }

                    if(this.registerPw.length<=6||this.registerPw.length>=6&&!(/[^0-9]+/.test(this.registerPw))){
                        this.showInfo("为了安全请见~请输入大于6位非纯数字密码",2000,"fromInfo");
                        return false;
                    }

                    $.ajax({
                        url:"/register",
                        type:"post",
                        data: {
                            // 二次验证所需的三个值
                            name:this.registerUser,
                            email:this.registerEmail,
                            password:this.registerPw,
                        },
                        success:(result)=>{
                            console.log("register",result);
                            this.showInfo(result.message,3000,"fromInfo");
                            if(result.type=true){
                                $("#"+this.registerId).closeModal();
                                $("#"+this.loginId).openModal();
                            }
                        }
                    });
                    return false;

                }else{
                    this.showInfo("请填写完整的注册表单~虽然这并没有什么乱用",1000,"fromInfo");
                    //this.fromInfo=;
                    return false;
                }
                e.stopImmediatePropagation();

            },
            showInfo:showInfo()
        },
        props:{
            loginId:{
                type:String,
                default:"loginModal"
            },
            registerId:{
                type:String,
                default:"registerModal"
            }
        },
        components:{

        }
    }
</script>