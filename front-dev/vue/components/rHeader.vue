<template>
    <div class="header col s12" :class="[headerWidth,navHide]">
        <button class="btn header-btn" :class="navButton" @click="showNav"><i class="material-icons">menu</i></button>
        <login-modal :login-id="loginModalId" @login-done="loginDone"></login-modal>
        <register-modal :register-id="registerModalId"></register-modal>
        <div class="row no-gutters">
            <div class="navcol s12 m12 ">
                <nav>
                    <div class="header-nav-title">
                        <div class="nav-logo">
                            <a href="#" class="brand-logo left">Relsoul</a>
                            <a href="#" class="nav-clear"><i class="material-icons right " @click="hideNav">clear</i></a>
                        </div>
                        <div class="col s12">
                            <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                        </div>
                        <div class="userInfo clearfix" v-if="isLogin">
                            <div class="row">
                                <div class="col s6 user-hello-wrap">
                                    <p class="user-hello">欢迎回来 <span class="green">{{loginName}}</span></p>
                                </div>
                                <div class="col s6 user-choose-box-wrap">
                                    <div class="user-choose-box" >
                                        <ul id="user-choose" class="dropdown-content" >
                                            <li><a href="#!">one<span class="badge">1</span></a></li>
                                            <li><a href="#!">two<span class="new badge">1</span></a></li>
                                            <li v-if="role>=10?true:false" ><a href="#!" v-link="{path:'/admin'}" >admin管理</a></li>
                                        </ul>
                                        <button class="btn dropdown-button user-choose-btn" @click="showUserMenu" data-activates="user-choose" >选择与访问
                                            <i class="material-icons right user-choose-arrow" >keyboard_arrow_down</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="header-nav header-nav-list hide-on-med-and-down">
                        <li><a href="#!">First Sidebar Link</a></li>
                        <li><a href="#!">Second Sidebar Link</a></li>
                        <!--
                            data-target to login id
                        -->
                        <li><button :data-target="loginModalId" class="btn waves-effect waves-purple modal-trigger">登陆</button></li>
                        <li><button :data-target="registerModalId" class="btn waves-effect waves-purple modal-trigger">注册</button></li>
                    </ul>

                    <ul id="slide-out" class="side-nav ">
                        <li><a href="#!">First Sidebar Link</a></li>
                        <li><a href="#!">Second Sidebar Link</a></li>
                        <li><button data-target="loginModal" class="btn waves-effect waves-purple modal-trigger">登陆</button></li>
                    </ul>
                </nav>
            </div>
        </div>

</div>

</template>
<style>

</style>
<script type="text/ecmascript-6">

    import loginModal from "./loginModal.vue"
    import registerModal from "./registerModal.vue"
    export default{
        data(){
            return{
                msg:'hello vue',
                navHide:{
                    "nav-hide":false
                },
                navButton:{
                    "header-btn-hide":true
                },
                loginModalId:"loginModal",
                registerModalId:"registerModal",
                isLogin:false,
                loginName:"",
                role:false
            }
        },
        ready(){
            if($(document).width()>420){
                $(".header nav").height($(document).height());
            }
            $(".modal-trigger").leanModal();
            if(window.localStorage.getItem("token")&&window.localStorage.getItem("name")){
                this.isLogin=true;
                this.loginName=window.localStorage.getItem("name");
                $.tokenAjax("/admin/me","get").then((data)=>{
                    console.log(91,data);
                    this.role=data.result.role;
                }).catch((error)=>{
                    this.isLogin=false;
                    window.localStorage.removeItem("token");
                    window.localStorage.removeItem("name");
                    $("#"+this.loginModalId).openModal();
                })
            };

        },
        props:{
            headerWidth:{
                type:String,
                default:"m2"
            }
        },
        route:{
            data(){

            }
        },
        methods:{
            loginDone(){
                this.isLogin=true;
            },
            hideNav(e){
                this.navHide["nav-hide"]=true;
                this.navButton["header-btn-hide"]=false;
                this.$dispatch("header-hide-change");
                e.stopImmediatePropagation();
                e.preventDefault();
            },
            showNav(e){
                this.$dispatch("header-show-change");
                this.navHide["nav-hide"]=false;
                this.navButton["header-btn-hide"]=true;
                e.preventDefault();
                e.stopImmediatePropagation();
            },
            showUserMenu(e){
                $(e.target).dropdown();
                $(e.target).click();
            }
        },
        components:{
            loginModal,
            registerModal
        }
    }
</script>