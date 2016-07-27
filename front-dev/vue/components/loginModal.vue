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
                    <p class="info-text"></p>
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
                            <div id="popup-captcha" class="col m5 offset-m3 s12 "></div>
                        </div>

                    </form>
                    <div class="row">
                        <button class="btn col m3 offset-m2 s12 login-btn animated" :class="{'flipInX':loginDone}" >登陆</button>
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
                passwordCls:{
                    "password":false
                },
                loginUser:"",
                loginPw:"",
                loginFailed:false,
                loginDone:false,
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
            loginValidate(captchaObj){
                $(".login-btn").on("click",(e)=>{
                    var validate = captchaObj.getValidate();
                    if (!validate) {
                        alert('请先完成验证！');
                        return false;
                    }
                    console.log("validate",validate);
                    console.log(validate.geetest_challenge,validate.geetest_validate,validate.geetest_seccode);
                    $.ajax({
                        url: "/login", // 进行二次验证
                        type: "post",
                        // dataType: "json",
                        data: {
                            // 二次验证所需的三个值
                            geetest_challenge: validate.geetest_challenge,
                            geetest_validate: validate.geetest_validate,
                            geetest_seccode: validate.geetest_seccode,
                            name:this.loginUser,
                            loginType:1,
                            password:this.loginPw,
                        },
                        success:(data)=>{
                            console.log(91,data);
                            if (data.type == "true") {
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
                            }else{
                                //登陆失败
                                this.loginFailed=true;
                                setTimeout(()=>{
                                    this.loginFailed=false;
                                },1000)
                            }
                        },
                    });
                    e.stopImmediatePropagation();
                    return false;
                });
                captchaObj.bindOn(".login-btn");
                captchaObj.appendTo("#popup-captcha");

            },
            loginClick(e){
                console.log(233);
                e.stopImmediatePropagation();
                return false;
            }
        },
        ready(){
            $.ajax({
                // 获取id，challenge，success（是否启用failback）
                url: "/login?t=" + (new Date()).getTime(), // 加随机数防止缓存
                type: "get",
                dataType: "json",
                success:(data)=>{
                    // 使用initGeetest接口
                    // 参数1：配置参数
                    // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
                    initGeetest({
                        gt: data.result.gt,
                        challenge: data.result.challenge,
                        product: "float", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                        offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                    },this.loginValidate );
                    console.log(data);
                },
            });
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