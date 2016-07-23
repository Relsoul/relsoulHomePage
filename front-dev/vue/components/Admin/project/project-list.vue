<template>
    <div class="project">
        <user-list-view
                :list-data="userList"
                :page-length="pageLength"
                :current-page="currentPage"
                :search-timer="searchTimer"
                :msg="msg"
                :hf="'/admin/project/'"
                :new-text="'新建项目'"
                @search-list="searchUser"
                @change-page="changePage"
                @delete-list="deleteUser"
                @new-list="newUser"
        ></user-list-view>
        project-list
    </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">
    import {showInfo} from "../../../service/showInfo";
    import userListView from "../user/userList-view.vue";

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
            newUser(){
                $.tokenAjax("/admin/project/","post")
                        .then((data)=>{
                            let id=data.result.id;
                            this.$router.go({"path":"/admin/project/"+id});
                        })
                        .catch((data)=>{
                            this.showInfo(data.message,3000,"msg");
                        })

            },
            searchUser(searchText){
                //与子组件属性进行同步
                this.searchText=searchText;
                //如果为空那么则是不搜索获取全部项目
                if(this.searchText.trim()==""){
                    return $.tokenAjax("/project/","get",{"page":this.currentPage}).then((data)=>{
                        this.showInfo(data.message,3000,"msg");
                        this.generate(data.result.count);
                        this.userList=data.result.userList;
                        console.log("userList",data);
                    }).catch()
                }


                //默认为获取搜索项目第一页
                $.tokenAjax("/project-search/","get",{"s":this.searchText,"page":1})
                        .then((data)=>{
                            this.showInfo(data.message,3000,"msg");
                            this.generate(data.result.count);
                            this.userList=data.result.userList;
                            console.log("搜索用户",data);
                        })
                        .catch()

            },
            deleteUser(id){
                $.tokenAjax("/admin/project/"+id,"delete")
                        .then((data)=>{
                            this.showInfo(data.message,1500,"msg");
                            setTimeout(()=>{
                                location.reload();
                            },2500);
                        })
                        .catch((data)=>{
                            this.showInfo(data.message,3000,"msg");
                        })

            },
            changePage(index,active=null){
                //与子组件属性进行同步
                this.currentPage=index;

                //如果不为空则是搜索项目分页
                if(this.searchText!==""){

                    return $.tokenAjax("/project-search/","get",{"page":this.currentPage,"s":this.searchText})
                            .then((data)=>{
                                this.userList=data.result.userList;
                            })
                            .catch();
                }

                $.tokenAjax("/project/","get",{"page":this.currentPage})
                        .then((data)=>{
                            this.userList=data.result.userList;
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
            $.tokenAjax("/project/","get",{"page":this.currentPage}).then((data)=>{
                this.showInfo(data.message,3000,"msg");
                this.generate(data.result.count);
                this.userList=data.result.userList;
                console.log("userList",data);
            }).catch()
        },
        components:{
            userListView

        }
    }
</script>