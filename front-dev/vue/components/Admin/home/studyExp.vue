<template>
    <div class="row">
        <p>{{msg}}</p>
        <ul class="collapsible expcoll" data-collapsible="expandable">
            <li class="" v-for="form in formList">
                <div class="collapsible-header "><i class="material-icons">build</i>{{form.exp_name?form.exp_name:"请填写经历名称"}} <i class="material-icons right" @click="deleteForm($event,form)">delete</i></div>
                <div class="collapsible-body ">
                    <div class="row">
                        <form class="col s12" enctype="multipart/form-data">
                            <div class="input-field col m6">
                                <input placeholder="Placeholder" id="admin-home-name" type="text" v-model="form.exp_name" class="validate">
                                <label for="admin-home-name" class="active">经历名称</label>
                            </div>
                            <div class="input-field col m6">
                                <input placeholder="Placeholder" id="admin-home-age" type="text" v-model="form.exp_start_time" class="validate">
                                <label for="admin-home-age"  class="active">经历起始时间</label>
                            </div>
                            <div class="input-field col m6">
                                <input placeholder="Placeholder" id="admin-home-email" type="text" v-model="form.exp_end_time" class="validate">
                                <label for="admin-home-email"  class="active">经历结束时间</label>
                            </div>
                            <div class="input-field col m6">
                                <input placeholder="Placeholder" id="admin-home-website"  type="text" v-model="form.exp_content" class="validate">
                                <label for="admin-home-website"  class="active">经历内容</label>
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
        <button class="btn" @click="addNewExp($event)">add</button>
        <button class="btn" @click="saveExp($event)">保存</button>
    </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">
    import {findNewValue} from "../../../service/findNewValue"
    import {showInfo} from "../../../service/showInfo"

    export default{
        data(){
            return{
                msg:'',
                formList:[],
                formUpdateList:[],
                test:[]
            }
        },
        methods:{
            addNewExp(e){

                this.formList.push({
                    exp_name:"",
                    exp_start_time:"",
                    exp_end_time:"",
                    exp_content:""
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
                if("exp_id" in deleteList[0]){
                    $.tokenAjax("/admin/home/studyexp","delete",{"exp_id":deleteList[0]["exp_id"]}).then((data)=>{
                        this.showInfo(data.message,3000,"msg")
                    }).catch()
                }
            },
            saveExp(e){

                //对比数据
                console.log(79,this.formList);
                let result=findNewValue(this.formList,this.formUpdateList);
                $.tokenAjax("/admin/home/studyexp","post",{"list":result}).then((data)=>{
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
            showInfo:showInfo()
        },
        watch:{

        },
        ready(){
            //获取数据
            $.promiseAjax("/home/studyexp","get").then((data)=>{
                let initObj=[{
                    exp_name:"",
                    exp_start_time:"",
                    exp_end_time:"",
                    exp_content:""
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