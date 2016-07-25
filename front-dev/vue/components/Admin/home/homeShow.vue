<template>
    <div class="row">
        <p>{{msg}}</p>
        <ul class="collapsible expcoll" data-collapsible="expandable">
            <li class="" v-for="item in list">
                <div class="collapsible-header "><i class="material-icons">build</i>{{item.title}} <i class="material-icons right" @click="deleteItem($event,form)">delete</i></div>
                <div class="collapsible-body ">
                    <div class="row">
                        <div class="col m6 s6">
                            <img :src="item.cover" class="responsive-img" alt="">
                        </div>
                        <div class="col m5 s5 offset-s1 offset-m1">
                            {{item.summary}}
                        </div>
                        <div class="col m12 m12">
                            <p>项目开始时间:<span>{{item.start_time}}</span></p>
                            <p>项目结束时间:<span>{{item.end_time}}</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <a class="btn col m4 s4" v-link="{'path':'/project/'+item.id}">查看</a>
                        <a class="btn col m4 s4" v-link="{'path':'/admin/project/'+item.id}">修改</a>
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
    export default{
        data(){
            return{
                list:[]
            }
        },
        methods:{
            deleteItem(){

            }
        },
        ready(){
            $.promiseAjax("/project-home-show","get")
                    .then((data)=>{
                        this.list=data.result;
            })

        },
        components:{

        }
    }
</script>