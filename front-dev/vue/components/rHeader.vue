<template>
    <div class="header ">
                <nav>
                    <div class="header-nav-title">
                        Relsoul
                    </div>
                    <ul class="header-nav header-nav-list hide-on-med-and-down">
                        <li><a href="#!">First Sidebar Link</a></li>
                        <li><a href="#!">Second Sidebar Link</a></li>
                        <li><a href=""><i class=" material-icons">face</i>2333</a></li>
                    </ul>

                    <ul id="slide-out" class="side-nav">
                        <li><a href="#!">First Sidebar Link</a></li>
                        <li><a href="#!">Second Sidebar Link</a></li>
                    </ul>
                    <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                </nav>
</div>

</template>
<style>

</style>
<script>

    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        components:{

        }
    }
</script>