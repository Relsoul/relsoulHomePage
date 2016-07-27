<template>
        <div id="fetchPassWord" class="modal fetch-password">
            <div class="modal-content">
                <div class="container">
                    <h6>{{msg}}</h6>
                    <div class="row">
                        <div class="input-field col s12">
                            <input placeholder="请输入用户名所对应的email"  id="first_name2" type="text" class="validate" v-model="email">
                            <label class="active" for="first_name2">email</label>
                        </div>
                        <button class="btn col s6 off-s3" @click="getPassword($event)">
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
<script type="text/ecmascript-6">

    import {showInfo} from "../../service/showInfo"


    export default{
        data(){
            return{
                msg:'',
                email:""
            }
        },
        methods:{
            showInfo:showInfo(),
            getPassword(){
                $.promiseAjax("/fetchpw","post",{email:this.email})
                        .then((data)=>{
                            this.showInfo(data.message,4000,"msg");
                        })
                        .catch((data)=>{
                            this.showInfo(data.message,3000,"msg");
                        })

            }
        },
        components:{

        }
    }
</script>