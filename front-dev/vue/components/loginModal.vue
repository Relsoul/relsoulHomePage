<template>
    <div :id="loginId" class="modal login-modal animated" :class="{'shake':loginFailed}">
        <div class="owl-login"  :class="passwordCls">
            <div class="hand"></div>
            <div class="hand hand-r"></div>
            <div class="arms">
                <div class="arm"></div>
                <div class="arm arm-r">
                </div>
            </div>
        </div>
        <div class="modal-content">
            <div class="container">
                <div class="row">
                    <h4>登陆</h4>
                    <p class="info-text">{{msg}}</p>
                    <form  class="col m12" >
                        <div class="row">
                            <div class="input-field col m5 offset-m3 s12 ">
                                <i class="material-icons prefix">account_box</i>
                                <input type="text" id="loginUser" name="loginUser" v-model="loginUser" class="validate">
                                <label for="loginUser">用户名/邮箱地址</label>
                            </div>
                            <div class="input-field col m5 offset-m3 s12 ">
                                <i class="material-icons prefix">vpn_key</i>
                                <input type="password" id="loginPw" name="loginPw" v-model="loginPw" @focus="pwFocus" @blur="pwBlur" class="validate">
                                <label for="loginPw">密码</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col m5 offset-m3 s6 ">
                                <i class="material-icons prefix">account_box</i>
                                <input type="text" id="loginUserText" name="loginUserText" v-model="loginCode" class="validate">
                                <label for="loginUserText">验证码</label>
                            </div>
                            <div class="col m4 s6 code-img-wrap">
                                <img class="code-img responsive-img" :src="dataImg" alt="" @click="changeCode">
                            </div>
                        </div>

                    </form>
                    <div class="row">
                        <button class="btn col m3 offset-m2 s12 login-btn animated" :class="{'flipInX':loginDone}" @click="loginClick" >登陆</button>
                        <button data-target="fetchPassWord" class=" modal-trigger modal-close btn col m3 offset-m1 s12 findpw-btn">忘记密码</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <p>还没有账号?赶紧来注册吧</p>
                    <button :data-target="registerId" class=" modal-close btn btn-flat left modal-trigger">注册</button>
                    <a href="#" class="btn modal-action modal-close waves-effect waves-green btn-flat">close</a>
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
                msg:"",
                passwordCls:{
                    "password":false
                },
                loginUser:"",
                loginPw:"",
                loginCode:"",
                loginType:1,
                loginFailed:false,
                loginDone:false,
                dataImg:"",
            }
        },
        methods:{
            pwFocus(e){
                this.passwordCls["password"]=true;
            },
            pwBlur(e){
                this.passwordCls["password"]=false;
            },
            showInfo:showInfo(),
            loginClick(e){

                if(/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/.test(this.loginUser)){
                    this.loginType=2;
                }

                $.promiseAjax("/login","post",{name:this.loginUser,loginType:this.loginType,password:this.loginPw,code:this.loginCode})
                        .then((data)=>{
                            this.showInfo(data.message,2000,"msg");
                            console.log("login",data);
                            this.loginDone=true;
                            //成功通知父级事件
                            this.$dispatch("login-done");
                            setTimeout(()=>{
                                this.loginDone=false;
                                $("#"+this.loginId).closeModal();
                            },800);
                            //设置token与role
                            window.localStorage.setItem("token",data.result.token);
                            window.localStorage.setItem("name",data.result.userName);
                            window.location.reload(true);
                        })
                        .catch((data)=>{
                            this.showInfo(data.message,2000,"msg");
                            this.loginFailed=true;
                            this.getCode();
                            setTimeout(()=>{
                                this.loginFailed=false;
                            },1000)
                        })
            },
            changeCode(){
                this.getCode();
            },
            getCode(){
                $.ajax({
                    // 获取id，challenge，success（是否启用failback）
                    url: "/login?t=" + (new Date()).getTime(), // 加随机数防止缓存
                    type: "get",
                    dataType: "json",
                    success:(data)=>{
                        this.dataImg=data.result;
                    },
                });
            }
        },
        ready(){
            this.getCode();
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