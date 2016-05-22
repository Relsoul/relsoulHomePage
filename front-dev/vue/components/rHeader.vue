<template>
    <div class="header ">
        <button class="btn header-btn" :class="navButton" @click="showNav">233</button>
        <login-modal :login-id="loginModalId"></login-modal>
        <register-modal :register-id="registerModalId"></register-modal>
        <div class="col s12 navcol" :class="[headerWidth,navHide]">
            <nav>
                <div class="header-nav-title" @click="hideNav" >
                    Relsoul
                </div>
                <ul class="header-nav header-nav-list hide-on-med-and-down">
                    <li><a href="#!">First Sidebar Link</a></li>
                    <li><a href="#!">Second Sidebar Link</a></li>
                    <li><a href=""><i class=" material-icons">face</i>2333</a></li>
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
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
            </nav>
        </div>
</div>

</template>
<style>

</style>
<script>

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
                registerModalId:"registerModal"
            }
        },
        ready(){
            if($(document).width()>420){
                $(".header nav").height($("body").height());
            }
            $(".modal-trigger").leanModal();
        },
        props:{
            headerWidth:String
        },
        methods:{
            hideNav(){
                this.navHide["nav-hide"]=true;
                this.navButton["header-btn-hide"]=false;
                this.$dispatch("header-hide-change");
            },
            showNav(){
                this.$dispatch("header-show-change");
                this.navHide["nav-hide"]=false;
                this.navButton["header-btn-hide"]=true;
            }
        },
        components:{
            loginModal,
            registerModal
        }
    }
</script>