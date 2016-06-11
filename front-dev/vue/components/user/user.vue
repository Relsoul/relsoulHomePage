<template>
    <div class="user">
        <div class="row no-gutters">

            <r-header @header-show-change="headerShow" @header-hide-change="headerHide" ></r-header>
            <div class="col s12 m10 right-content" :class="[Contentcls]">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script>

    import rHeader from "../rHeader.vue"
    export default{
        data(){
            return{
                msg:'hello vue',
                Contentcls:{
                    "m10":true,
                    "m12":false
                }
            }
        },
        methods:{
            headerHide(){
                this.Contentcls.m10=false;
                this.Contentcls.m12=true;
            },
            headerShow(){
                this.Contentcls.m10=true;
                this.Contentcls.m12=false;
            }
        },
        components:{
            rHeader
        }
    }
</script>