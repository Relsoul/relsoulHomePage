<template>
    <div class="user-data">
        <div class="container">
            <div class="row">
                <div class="col s12 m6 offset-m3">
                    <div class="card">
                        <div class="card-image">
                            <img src="img/user-title.jpg">
                            <span class="card-title">用户资料</span>
                        </div>
                        <div class="card-content">
                            <p>{{msg}}</p>
                            <p><i class="material-icons">perm_identity</i><span class=" user-text">{{user.name}}</span></p>
                            <p><i class="material-icons">email</i><span class=" user-text">{{user.email}}</span></p>
                        </div>
                        <div class="card-action">
                            <a href="#" v-link="{path:'/user/change/'+user.id}" class="btn">修改个人资料</a>
                        </div>
                    </div>
                </div>
            </div>
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
                msg:"",
                user:{}
            }
        },
        methods:{
            showInfo:showInfo()
        },
        ready(){

        },
        route:{
            data(){
                $.tokenAjax("/me","get").then((data)=>{
                    console.log("userData",data)
                }).catch();
                let id=this.$route.params.userId;
                $.tokenAjax("/user/"+id,"get")
                        .then((data)=>{
                            this.user=data.result.user;
                            this.showInfo(data.message,3000,"msg");
                        })
                        .catch((data)=>{

                        })
            }

        },
        components:{

        }
    }
</script>