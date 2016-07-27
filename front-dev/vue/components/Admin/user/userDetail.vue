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
                                               <input id="email" type="email" class="validate" v-model="userInfo.email">
                                               <label for="email" >email</label>
                                           </div>
                                       </div>
                                       <div class="row" v-if="adminRole<10">
                                           <div class="input-field col s12">
                                               <input id="oldpw" type="text" class="validate" v-model="userInfo.oldPassWord">
                                               <label for="oldpw">oldpw</label>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="input-field col s12">
                                               <input id="pw" type="text" class="validate"  v-model="userInfo.password" >
                                               <label for="pw">password</label>
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
                                           <button class="col m6 btn " @click="updateUser($event)" v-if="!newUser">提交修改</button>
                                           <button class="col m6 btn" @click="addUser($event)" v-if="newUser">添加新用户</button>
                                       </div>
                                   </form>
                               </div>
                           </div>

                       </div>
                       <div class="card-action">

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
                adminRole:0,
                newUser:false,
            }
        },
        methods:{
            showInfo:showInfo(),
            addUser(e){
                let {name,password,oldPassWord,role,email}=this.userInfo;

                if(/\s+/gi.test(name)){
                    this.showInfo("请不要再用户名中包含空格哦~",2000,"msg");
                    return false;
                }

                if(password&&(password.length<=6||password.length>=6)&&!(/[^0-9]+/.test(password))){
                    this.showInfo("为了安全请见~请输入大于6位非纯数字密码",2000,"msg");
                    return false;
                }

                $.tokenAjax("/admin/user/","post",{name,password,role,email})
                        .then((data)=>{
                            this.showInfo(data.message,3000,"msg");
                            //成功清除表单信息.
                            this.userInfo={}
                        })
                        .catch((data)=>{
                            this.showInfo(data.message,3000,"msg");
                        });

                return false;
            },
            updateUser(e){
                let userId=this.$route.params.userId;
                let {name,password,oldPassWord,role,email}=this.userInfo;


                if(/\s+/gi.test(name)){
                    this.showInfo("请不要再用户名中包含空格哦~",2000,"msg");
                    return false;
                }

                if(password&&(password.length<=6||password.length>=6)&&!(/[^0-9]+/.test(password))){
                    this.showInfo("为了安全请见~请输入大于6位非纯数字密码",2000,"msg");
                    return false;
                }


                $.tokenAjax("/user/"+userId,"put",{name,password,oldPassWord,role,email})
                        .then((data)=>{
                            this.showInfo(data.message,3000,"msg");
                            //更新成功移除下重新登陆
                            window.localStorage.removeItem("name");
                            window.localStorage.removeItem("token");
                            this.$router.go({path:"/"});
                            //重新打开登陆框
                            $("#loginModal").openModal();
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
                //新用户逻辑处理
                if(userId=="newuser"){
                    //上级路由已经做过用户验证.这里不再验证.
                    this.newUser=true;
                    this.adminRole=20;
                }else{
                    $.tokenAjax("/user/"+userId,"get")
                            .then((data)=>{
                                this.userInfo=data.result.user;
                                this.adminRole=data.result.role;
                                this.$nextTick(()=>{
                                    Materialize.updateTextFields();
                                });
                                console.log("获取单个用户",data)
                            })
                            .catch((data)=>{
                                this.$router.go({path:"/"})
                            })
                }
            }
        },
        ready(){

        },
        components:{

        }
    }
</script>