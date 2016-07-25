<template>
    <div class="project-list">
            <div class="row">
                <div class="col s4 offset-s1" v-for="i in list">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="img/navTitle.png">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">{{i.name}}<i class="material-icons right">more_vert</i></span>
                            <p><a href="#" v-link="{'path':'/project/'+i.id}">详情</a></p>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">{{i.name}}<i class="material-icons right">close</i></span>
                            <div class="project-md-preview">
                                {{{i.mdContent}}}
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
                mdPreview:null
            }
        },
        route:{
            data(){
                console.log(24,this.page);
                $.promiseAjax("/project/","get",{"page":this.page})
                        .then((data)=>{
                            console.log(26,data);

                            //解析并转markdown
                            for(let i of data.result.userList){
                                i.mdContent=window.markdown.toHTML(i.content);
                            }

                            this.list=data.result.userList;
                        })
                        .catch()


            }
        },
        components:{

        }
    }
</script>