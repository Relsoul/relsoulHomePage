<template>
    <div :id="registerId" class="modal register-modal">
        <div class="modal-content">
            <div class="container">
                <div class="row">
                    <h4>注册</h4>
                    <p class="info-text"></p>
                    <form action="">

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
<script>

    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        ready(){
            $(".modal-trigger").leanModal();
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