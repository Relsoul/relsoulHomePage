<template>
        <div id="fetchPassWord" class="modal fetch-password">
            <div class="modal-content">
                <div class="container">
                    <p>{{msg}}</p>
                    <div class="row">
                        <div class="input-field col s12">
                            <input  id="first_name2" type="text" class="validate">
                            <label class="active" for="first_name2">email</label>
                        </div>
                        <button class="btn col s6 off-s3">
                            提交
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class=" modal-close modal-action modal-close waves-effect waves-green btn-flat">关闭</a>
            </div>
        </div>
</template>
<style>

</style>
<script>

    export default{
        data(){
            return{
                msg:'hello vue',
            }
        },
        methods:{

        },
        components:{

        }
    }
</script>