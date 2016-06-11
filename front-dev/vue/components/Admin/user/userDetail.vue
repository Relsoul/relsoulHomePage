<template>
   <div class="user-detail">
       <div class="container">
           <div class="row">
               <div class="col s12 m8 offset-m2">
                   <div class="card blue-grey darken-1">
                       <div class="card-content white-text">
                           <span class="card-title">用户信息</span>
                           <p>{{msg}}</p>
                           <div class="container">
                               <div class="row">
                                   <form class="col m12">
                                       <div class="row">
                                           <div class="input-field col s12">
                                               <input id="name" type="text" class="validate" v-model="userInfo.name">
                                               <label for="name">name</label>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="input-field col s12">
                                               <input id="pw" type="text" class="validate" >
                                               <label for="pw">password</label>
                                           </div>
                                       </div>
                                       <div class="row" v-if="adminRole<10">
                                           <div class="input-field col s12">
                                               <input id="oldpw" type="text" class="validate" v-model="userInfo.oldPassWord">
                                               <label for="oldpw">oldpw</label>
                                           </div>
                                       </div>
                                       <div class="user-detail-admin">
                                           <div class="row" v-if="adminRole>=10">
                                               <div class="input-field col s12">
                                                   <input id="role" type="text" class="validate" v-model="userInfo.role">
                                                   <label for="role" class="active">role</label>
                                               </div>
                                           </div>
                                       </div>

                                       <div class="row">
                                           <div class="input-field col s12">
                                               <input id="email" type="email" class="validate" v-model="userInfo.email">
                                               <label for="email" >email</label>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <button class="col m6 btn " @click="updateUser($event)">提交修改</button>
                                       </div>
                                   </form>
                               </div>
                           </div>

                       </div>
                       <div class="card-action">
                           <a href="#">This is a link</a>
                           <a href='#'>This is a link</a>
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

    import {showInfo} from "../../../service/showInfo";

    export default{
        data(){
            return{
                msg:'',
                userInfo:{},
                adminRole:0
            }
        },
        methods:{
            showInfo:showInfo(),
            updateUser(e){
                let userId=this.$route.params.userId;
                let {name,password,oldPassWord,role,email}=this.userInfo;
                $.tokenAjax("/user/"+userId,"put",{name,password,oldPassWord,role,email})
                        .then((data)=>{
                            this.showInfo(data.message,3000,"msg");
                        })
                        .catch((data)=>{
                            this.showInfo(data.message,3000,"msg");
                        });

                return false;
            }
        },
        route:{
            data(transition){
                let userId=this.$route.params.userId;
                $.tokenAjax("/user/"+userId,"get")
                        .then((data)=>{
                            this.userInfo=data.result.user;
                            this.adminRole=data.result.role;
                            this.$nextTick(()=>{
                                Materialize.updateTextFields();
                            });
                            console.log("获取单个用户",data)
                        })
                        .catch()
            }
        },
        ready(){

        },
        components:{

        }
    }
</script>