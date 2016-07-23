<template>
    <div class="admin-home">
        <div class="row">
            <div class="container">
                <ul class="collapsible popout" data-collapsible="accordion">
                    <li class="">
                        <div class="collapsible-header active"><i class="material-icons">build</i>关于我</div>
                        <div class="collapsible-body ">
                            <admin-about-me></admin-about-me>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">build</i>学习经验</div>
                        <div class="collapsible-body">
                            <admin-study-exp></admin-study-exp>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">build</i>技能管理</div>
                        <div class="collapsible-body">
                            <admin-skill></admin-skill>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">build</i>推荐首页项目</div>
                        <div class="collapsible-body">
                            <admin-skill></admin-skill>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</template>
<style>

</style>
<script type="text/ecmascript-6">
    import {showInfo} from "../../service/showInfo"
    import adminAboutMe from "./home/aboutMe.vue"
    import adminStudyExp from "./home/studyExp.vue"
    import adminSkill from "./home/Skill.vue"

    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        methods:{
            showInfo:showInfo()
        },
        ready(){
            $('.collapsible').collapsible({
                accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
            });
        },
        components:{
            adminAboutMe,
            adminStudyExp,
            adminSkill
        }
    }
</script>