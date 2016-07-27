<template>
    <div class="row">
        <p>{{msg}}</p>
        <ul class="collapsible expcoll" data-collapsible="expandable">
            <li class="" v-for="form in formList">
                <div class="collapsible-header "><i class="material-icons">build</i>{{form.skill_name?form.skill_name:"请填写技能名称"}} <i class="material-icons right" @click="deleteForm($event,form)">delete</i></div>
                <div class="collapsible-body ">
                    <div class="row">
                        <form class="col s12" >
                            <div class="input-field col m12 s12">
                                <input placeholder="Placeholder" id="admin-home-email" type="text" v-model="form.skill_name" class="validate">
                                <label for="admin-home-email"  class="active">技能名称</label>
                            </div>
                            <div class="input-field col m12">
                                <p>技能熟练起始度</h4>
                                <p class="range-field">
                                    <input type="range" v-model="form.start_exp"  min="0" max="100" />
                                </p>
                            </div>
                            <div class="input-field col m12 s12">
                                <p>技能熟练结束度</p>
                                <p class="range-field">
                                    <input type="range" v-model="form.end_exp" min="0" max="100" />
                                </p>
                            </div>

                        </form>
                    </div>
                </div>
            </li>
            <!--           <li class="">
                           <div class="collapsible-header active"><i class="material-icons">build</i>list2</div>
                           <div class="collapsible-body ">
                            2222
                           </div>
                       </li>-->
        </ul>
        <button class="btn" @click="addNewSkill($event)">add</button>
        <button class="btn" @click="saveSkill($event)">保存</button>
    </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">
    import {showInfo} from "../../../service/showInfo"
    import {findNewValue} from "../../../service/findNewValue"
    export default{
        data(){
            return{
                msg:'',
                formList:[],
                formUpdateList:[],
            }
        },
        methods:{
            showInfo:showInfo(),
            addNewSkill(){
                this.formList.push({
                    skill_name:"",
                    start_exp:"",
                    end_exp:"",
                })
            },
            deleteForm(e,form){
                e.stopImmediatePropagation();
                let index=this.formList.indexOf(form);
                let deleteList=this.formList.splice(index,1);
                //已经在findNewValue判断了
                /*let oldIndex=this.formUpdateList.indexOf(form);*/
                /*if(!!~oldIndex){
                 this.formUpdateList.splice(oldIndex,1);
                 }*/
                if("skill_id" in deleteList[0]){
                    $.tokenAjax("/admin/home/skill","delete",{"skill_id":deleteList[0]["skill_id"]}).then((data)=>{
                        this.showInfo(data.message,3000,"msg")
                    }).catch()
                }
            },
            saveSkill(e){

                //对比数据
                let result=findNewValue(this.formList,this.formUpdateList);

                $.tokenAjax("/admin/home/skill","post",{"list":result}).then((data)=>{
                    this.showInfo(data.message,3000,"msg");
                    setTimeout(()=>{
                        location.reload();
                    },2000);

                    /*result.forEach((e,i)=>{
                     //更新原有数据 添加exp_id
                     let newIndex=this.formList.indexOf(e);
                     let oldIndex=this.formUpdateList.indexOf(e);

                     if(!!~newIndex&&!!~oldIndex){
                     this.formUpdateList[oldIndex]["exp_id"]=data.result[i];
                     this.formList[newIndex]["exp_id"]=data.result[i];
                     }else{
                     console.log(104,"刷新")
                     }
                     })*/
                }).catch()
            },
        },
        ready(){
            $.promiseAjax("/home/skill","get").then((data)=>{
                let initObj=[{
                    skill_name:"",
                    start_exp:1,
                    end_exp:10,
                }];
                let result=data.result.length?data.result:initObj;
                this.formList=result;
                this.formUpdateList=JSON.parse(JSON.stringify(result));
                this.showInfo(data.message,3000,"msg")
            }).catch()

        },
        components:{

        }
    }
</script>