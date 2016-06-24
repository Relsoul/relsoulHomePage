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
                            <div id="preview"></div>
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
                console.log(24,this.page)
                $.promiseAjax("/project/","get",{"page":this.page})
                        .then((data)=>{
                            console.log(26,data);
                            this.list=data.result.userList;
                            this.mdPreview = editormd.markdownToHTML("preview", {
                                markdown        : markdown ,//+ "\r\n" + $("#append-test").text(),
                                //htmlDecode      : true,       // 开启 HTML 标签解析，为了安全性，默认不开启
                                htmlDecode      : "style,script,iframe",  // you can filter tags decode
                                //toc             : false,
                                tocm            : true,    // Using [TOCM]
                                //tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层
                                //gfm             : false,
                                //tocDropdown     : true,
                                // markdownSourceCode : true, // 是否保留 Markdown 源码，即是否删除保存源码的 Textarea 标签
                                emoji           : true,
                                taskList        : true,
                                tex             : true,  // 默认不解析
                                flowChart       : true,  // 默认不解析
                                sequenceDiagram : true,  // 默认不解析
                            });
                        })
                        .catch()


            }
        },
        components:{

        }
    }
</script>