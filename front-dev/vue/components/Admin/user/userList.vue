<template>
    <div class="user-list">
        <div class="container">
            <p>{{msg}}</p>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix white-text">search</i>
                            <input id="icon_prefix" type="text" class="validate" v-model="searchText" @change="searchUser($event)">
                            <label for="icon_prefix" class="white-text">搜索</label>
                        </div>
                    </div>
                </form>
            </div>
            <ul class="collection">
                <li class="collection-item" v-for="user in userList">{{user.name}}</li>
            </ul>
            <ul class="pagination white-text">
                <li class="" :class="{'disabled':currentPage<=1?true:false,'waves-effect':currentPage<=1?false:true}" @click="changePage($event,currentPage,'prev')">
                    <a ><i class="material-icons">chevron_left</i></a>
                </li>
                <li class="waves-effect" :class="page.cls"  v-for="page in pageLength" @click="changePage($event,page.num)">
                    <a>{{page.num}}</a>
                </li>

                <li class=""  :class="{'disabled':currentPage>=pageLength.length?true:false,
                'waves-effect':currentPage>=pageLength.length?false:true}" @click="changePage($event,currentPage,'next')">
                    <a  ><i class="material-icons">chevron_right</i></a>
                </li>
            </ul>
        </div>

        user-list
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
                searchTimer:null,
                searchText:"",
                pageLength:[],
                currentPage:1,
                userList:[]
            }
        },
        methods:{
            showInfo:showInfo(),
            searchUser(e){

                if(this.searchTimer){
                    return false;
                }
                //延迟处理搜索
                this.searchTimer=setTimeout(()=>{
                    $.tokenAjax("/user/","get",{"s":this.searchText})
                            .then((data)=>{
                                this.searchTimer=null;
                                this.showInfo(data.message,3000,"msg");
                                this.generate(data.result.count);
                                this.userList=data.result;
                                console.log("搜索用户",data);
                            })
                            .catch()
                },800)

            },
            changePage(e,index,active=null){
                //判断是否已经是第一页或者最后一页

                if(active=="prev"){
                    index--
                }
                if(active=="next"){
                    index++
                }

                console.log("index",index,"pageLength",this.pageLength.length);
                if(index<=0||index>this.pageLength.length){
                    return false;
                }

                //处理当前选择元素样式
                for(let elem of this.pageLength){
                    elem.cls="waves-effect"
                }
                //因为index是从1开始 所以这里要-1对上数组索引
                this.pageLength[index-1].cls='active';
                //当前分页设置为所点击的分页
                this.currentPage=index;
                $.tokenAjax("/user/","get",{"page":this.currentPage})
                        .then((data)=>{
                            this.userList=data.result;
                        })
                        .catch();
                return false

            },
            //分页处理函数
            generate(count){
                //清空原有的page分页列表
                this.currentPage=1;
                this.pageLength=[];
                let len=Math.ceil(count/10);
                //替换num为array 以循环生成数据,为了方便更改class 所以采用了object
                //num从1开始
                for(let i=0;i<len;i++){
                    let _o={num:i+1,cls:"waves-effect"};
                    if(i==0){
                        _o.cls="active"
                    }
                    this.pageLength.push(_o)
                }
            }
        },
        ready(){
            $.tokenAjax("/user/","get",{"page":this.currentPage}).then((data)=>{
                this.showInfo(data.message,3000,"msg");
                this.generate(data.result.count);
                this.userList=data.result;
                console.log("userList",data);

            }).catch()
        },
        components:{

        }
    }
</script>