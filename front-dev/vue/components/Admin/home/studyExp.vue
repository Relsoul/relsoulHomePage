<template>
   <div class="row">
       <p></p>
       <ul class="collapsible expcoll" data-collapsible="expandable">
           <li class="" v-for="form in formList">
               <div class="collapsible-header "><i class="material-icons">build</i>{{form.expName?form.expName:"请填写经历名称"}} <i class="material-icons right" @click="deleteForm($event,form)">delete</i></div>
               <div class="collapsible-body ">
                   <div class="row">
                       <form class="col s12" enctype="multipart/form-data">
                           <div class="input-field col m6">
                               <input placeholder="Placeholder" id="admin-home-name" type="text" v-model="form.expName" class="validate">
                               <label for="admin-home-name">经历名称</label>
                           </div>
                           <div class="input-field col m6">
                               <input placeholder="Placeholder" id="admin-home-age" type="text" v-model="form.expStartTime" class="validate">
                               <label for="admin-home-age">经历起始时间</label>
                           </div>
                           <div class="input-field col m6">
                               <input placeholder="Placeholder" id="admin-home-email" type="text" v-model="form.expEndTime" class="validate">
                               <label for="admin-home-email">经历结束时间</label>
                           </div>
                           <div class="input-field col m6">
                               <input placeholder="Placeholder" id="admin-home-website"  type="text" v-model="form.expContent" class="validate">
                               <label for="admin-home-website">经历内容</label>
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
       <button class="btn">保存</button>
   </div>
</template>
<style>

</style>
<script>

    export default{
        data(){
            return{
                msg:'hello vue',
                formList:[{
                    expName:"",
                    expStartTime:"",
                    expEndTime:"",
                    expContent:""
                }]
            }
        },
        methods:{
            addNewExp(e){
                this.formList.push({
                    expName:"",
                    expStartTime:"",
                    expEndTime:"",
                    expContent:""
                })
            },
            deleteForm(e,form){
                e.stopImmediatePropagation();
                let index=this.formList.indexOf(form);
                this.formList.splice(index,1);
            }
        },
        components:{

        }
    }
</script>