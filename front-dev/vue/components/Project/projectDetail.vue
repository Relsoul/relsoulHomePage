<template>
    <div class="project-detail">
        <div class="container">
            <div class="row teal lighten-1 card-panel">
                <div class="col m4 s12 ">
                    <h4 class="white-text  center-align">项目名称</h4>
                    <h5 class="white-text center-align">{{title}}</h5>
                </div>
                <div class="col m4 s12 ">
                    <h4 class="white-text center-align">项目简介</h4>
                    <h5 class="white-text center-align">{{summary}}</h5>
                </div>
                <div class="col m4 s12 ">
                    <h4 class="white-text center-align">时间</h4>
                    <h5 class="white-text center-align">{{start_time}}至{{end_time}}</h5>
                </div>
            </div>
            <div class="row detail-content-wrap">
                <div id="normal-markdown" class="col s12 m12 markdown-body detail-markdown">
                    {{{content}}}
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
                msg:'hello vue',
                content:"",
                title:"",
                summary:"",
                start_time:"",
                end_time:""
            }
        },
        route:{
            data(){
                let projectId=this.$route.params.projectId;
                $.promiseAjax("/project/"+projectId,"get")
                        .then((data)=>{
                            this.content=markdown.toHTML(data.result["content"]);
                            this.title=data.result["name"];
                            this.summary=data.result["summary"];
                            this.start_time=data.result['start_time'];
                            this.end_time=data.result['end_time'];
                        })
                        .catch();
            }
        },
        components:{

        }
    }
</script>