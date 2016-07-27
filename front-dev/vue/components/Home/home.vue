<template>
    <div class="home">
            <div class="row no-gutters">
                <r-header  @header-show-change="headerShow" @header-hide-change="headerHide" :header-width="Headercls"></r-header>

                <div class="col s12  "  :class="Contentcls">
                    <div class=" home-content right-content" >
                        <home-title></home-title>
                        <home-about-me></home-about-me>
                        <time-line title="学习经历" cls="home-study" get-url="/home/studyexp/" ></time-line>
                        <time-line title="项目经验" cls="home-project" :out-project-exp="projectExp" ></time-line>
                        <home-skills></home-skills>
                    </div>
                </div>
            </div>
            <r-footer></r-footer>
    </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">
    import rFooter from '../rFooter.vue'
    import rHeader from '../rHeader.vue'
    import homeTitle from "./homeTitle.vue"
    import homeAboutMe from "./homeAboutMe.vue"
    import timeLine from "./timeLine.vue"
    import homeSkills from "./homeSkills.vue"
    export default{
        data(){
            return{
                projectExp:[],
                msg:'hello vue',
                Headercls:"m2",
                Contentcls:{
                    "m10":true,
                    "m12":false,
                    "show-content":true
                }
            }
        },
        methods:{
            headerHide(){
                this.Contentcls.m10=false;
                this.Contentcls.m12=true;
                this.Contentcls["show-content"]=false;
                $("body").removeClass("body-content-show");
            },
            headerShow(){
                this.Contentcls.m10=true;
                this.Contentcls.m12=false;
                this.Contentcls["show-content"]=true;
                $("body").addClass("body-content-show");
            }
        },
        ready(){
            $.promiseAjax("/project-home-show","get")
                    .then((data)=>{
                        let list=data.result;
                        list.map((n)=>{
                            n.exp_name=n.title;
                            n.exp_start_time=n.start_time;
                            n.exp_end_time=n.end_time;
                            n.exp_content=n.summary;
                            this.projectExp.push(n);
                        });
            })
        },
        route:{
        },
        components:{
            rFooter,
            rHeader,
            homeTitle,
            homeAboutMe,
            timeLine,
            homeSkills
        }
    }
</script>