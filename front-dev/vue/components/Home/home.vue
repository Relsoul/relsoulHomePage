<template>
    <div class="home">
            <div class="row no-gutters">
                <r-header  @header-show-change="headerShow" @header-hide-change="headerHide" :header-width="Headercls"></r-header>

                <div class="col s12 "  :class="Contentcls">
                    <div class=" home-content">
                        <home-title></home-title>
                        <home-about-me></home-about-me>
                        <time-line title="test time-line project" cls="home-project"></time-line>
                        <time-line title="test time-line project2" cls="home-project2"></time-line>
                        <home-skills></home-skills>
                    </div>
                </div>
            </div>
            <r-footer></r-footer>
    </div>
</template>
<style>

</style>
<script>
    import rFooter from '../rFooter.vue'
    import rHeader from '../rHeader.vue'
    import homeTitle from "./homeTitle.vue"
    import homeAboutMe from "./homeAboutMe.vue"
    import timeLine from "./timeLine.vue"
    import homeSkills from "./homeSkills.vue"
    export default{
        data(){
            return{
                msg:'hello vue',
                Headercls:"m2",
                Contentcls:{
                    "m10":true,
                    "m12":false,
                    "show-content":true
                },
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