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
                            <div class="input-field col m5 offset-m3 ">
                                <i class="material-icons prefix">account_box</i>
                                <input type="text" id="loginUser" name="loginUser" class="validate">
                                <label for="loginUser">用户名/邮箱地址</label>
                            </div>
                            <div class="input-field col m5 offset-m3 ">
                                <i class="material-icons prefix">vpn_key</i>
                                <input type="password" id="loginPw" name="loginPw" @focus="pwFocus" @blur="pwBlur" class="validate">
                                <label for="loginPw">密码</label>
                            </div>
                        </div>
                        <div class="row">
                            <button class="btn col m3 offset-m2 s12 login-btn">登陆</button>
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
<script>

    export default{
        data(){
            return{
                passwordCls:{
                    "password":false
                },
            }
        },
        methods:{
            pwFocus(e){
                this.passwordCls["password"]=true;
            },
            pwBlur(e){
                this.passwordCls["password"]=false;
            }
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