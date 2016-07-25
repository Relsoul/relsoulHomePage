<template>
    <div class="project-detail">
        <div class="container">

        </div>
    </div>
</template>
<style>

</style>
<script type="text/ecmascript-6">

    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        route:{
            data(){
                let projectId=this.$route.params.userId;

            }
        },
        components:{

        }
    }
</script>