<template>
    <div class="project-list">
            <div class="row">
                <div class="col m4 offset-m1" v-for="i in list">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator responsive-img" :src="i.cover?(i.cover.indexOf('http')!=-1?i.cover:'img/navTitle.png'):'img/navTitle.png'">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">{{i.name}}<i class="material-icons right">more_vert</i></span>
                            <p><a href="#" v-link="{'path':'/project/'+i.id}">详情</a></p>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">{{i.name}}<i class="material-icons right">close</i></span>
                            <div class="project-md-preview">
                                {{{i.summary}}}
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

    export default{
        data(){
            return{
                msg:'',
                page:1,
                list:[],
                mdPreview:null,
                offSetHeight:0,
                prevOffSetHeight:0,
                getPageLock:false
            }
        },
        route:{
            data(){
                this.getNextPage();
            }
        },
        methods:{
            getNextPage(){
                //锁定正在获取,无法再进行新的获取
                if(this.getPageLock){
                    console.log("getPageLock存在,无法获取下一页");
                    return false;
                }
                console.log("获取下一页");
                this.getPageLock=true;
                $.promiseAjax("/project/","get",{"page":this.page})
                        .then((data)=>{
                            this.list=this.list.concat(data.result.userList);
                            //算出最后图片scrollTop距离
                            this.$nextTick(()=>{
                                this.getLastCardHeight();
                                if(data.result.userList.length<=0){
                                    return this.getPageLock=true;
                                }
                                this.getPageLock=false;
                                this.page++;
                            });
                        })
            },
            getLastCardHeight(){
                this.offSetHeight=$(".card").last().offset().top;
            }
        },
        ready(){
            $(window).on("scroll",(e)=>{

                let windowScroll=$(window).scrollTop();

                //判断上一次滚动获取的数据是否小于这一次获取的距离,以及是否正在获取下一页数据中
                console.log("滚动",windowScroll,"this.offSetHeight",this.offSetHeight);

                if(windowScroll+200>=this.offSetHeight){
                    this.getNextPage();
                }

            })
        },
        components:{

        }
    }
</script>