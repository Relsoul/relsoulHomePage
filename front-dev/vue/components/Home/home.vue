<template>
    <div class="home">
            <div class="row no-gutters">

                <div class="col s12 m3">
                    <r-header></r-header>
                </div>

                <div class="col s12 m9  ">
                    <div class=" home-content">
                        <home-title></home-title>
                        <home-about-me></home-about-me>
                        <time-line title="test time-line project" cls="home-project"></time-line>
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
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        components:{
            rFooter,
            rHeader,
            homeTitle,
            homeAboutMe,
            timeLine
        }
    }
</script>