<template>
    <div :id="loginId" class="modal login-modal">
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
                    <form action="" class="col m12">
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
                        <div class="row">
                            <button class="btn col m3 offset-m2 s12 login-btn" >登陆</button>
                            <button class="btn col m3 offset-m1 s12 findpw-btn">忘记密码</button>
                        </div>
                    </form>
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

    export default{
        data(){
            return{
                passwordCls:{
                    "password":false
                },
                loginUser:"",
                loginPw:""
            }
        },
        methods:{
            pwFocus(e){
                this.passwordCls["password"]=true;
            },
            pwBlur(e){
                this.passwordCls["password"]=false;
            },
            loginValidate(captchaObj){
                $(".login-btn").on("click",(e)=>{
                    e.stopPropagation();
                    var validate = captchaObj.getValidate();
                    if (!validate) {
                        alert('请先完成验证！');
                        return false;
                    }
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
                        success: function (result) {
                            console.log(91,result);
                           /* if (result == "Yes!") {
                                $(document.body).html('<h1>登录成功</h1>');
                            } else {
                                $(document.body).html('<h1>登录失败</h1>');
                            }*/
                        }
                    });
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