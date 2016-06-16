<template>
        <div class="container">
            <p>{{msg}}</p>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix white-text">search</i>
                            <input id="icon_prefix" type="text" class="validate" v-model="searchText" @change="searchUser($event)" @click="searchUser($event)">
                            <label for="icon_prefix" class="white-text">搜索</label>
                        </div>
                    </div>
                </form>
            </div>
            <ul class="collection">
                <li class="collection-item"  v-for="list in listData">
                    <span class="user-name">{{list.name}}</span>
                    <div class="secondary-content">
                        <a class="btn" v-link="{path:'/admin/user/'+list.id}">修改</a>
                        <a class="btn" @click="deleteUser($event,list.id)" >删除</a>
                    </div>
                </li>
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
</template>
<style>

</style>
<script type="text/ecmascript-6">
    import {showInfo} from "../../../service/showInfo";
    export default{
        data(){
            return{
                searchText:"",
            }
        },
        props:["listData","pageLength","currentPage","searchTimer","msg"],
        methods:{
            searchUser(e){
                if(this.searchTimer){
                    return false;
                }

                this.searchTimer=setTimeout(()=>{
                    this.searchTimer=null;
                    this.$dispatch('search-list', this.searchText);
                },800);

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

                this.$dispatch('change-page', index,active);

                return false;

            },
            deleteUser(){
                let r=window.confirm("确定要删除该用户?");
                if(r==false){
                    return false
                }

                this.$dispatch('delete-list', this.msg);

            },
        },
        components:{

        }
    }
</script>