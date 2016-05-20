<template>
    <div id="wrapper">
       <router-view></router-view>
    </div>
</template>
<style>

</style>
<script>
    import rHeader from './components/rHeader.vue'
    import rFooter from './components/rFooter.vue'
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        components:{
            rHeader,
            rFooter
        }
    }
</script>