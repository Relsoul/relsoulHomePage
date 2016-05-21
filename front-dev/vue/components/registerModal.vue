<template>
    <div :id="registerId" class="modal register-modal">
        <div class="modal-content">
            <div class="container">
                <div class="row">

                    <div class="modal-footer">
                        <p>还没有账号?赶紧来注册吧</p>
                        <a href="#" class="btn btn-flat left">注册</a>
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
                default:"registerId"
            }
        },
        components:{

        }
    }
</script>