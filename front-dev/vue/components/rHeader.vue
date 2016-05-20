<template>
    <div class="header ">
        <button class="btn header-btn" :class="navButton" @click="showNav">233</button>
        <div class="col s12 navcol" :class="[headerWidth,navHide]">
            <nav>
                <div class="header-nav-title" @click="hideNav" >
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
</div>

</template>
<style>

</style>
<script>

    export default{
        data(){
            return{
                msg:'hello vue',
                navHide:{
                    "nav-hide":false
                },
                navButton:{
                    "header-btn-hide":true
                }
            }
        },
        props:{
            headerWidth:String
        },
        methods:{
            hideNav(){
                this.navHide["nav-hide"]=true;
                this.navButton["header-btn-hide"]=false;
                this.$dispatch("header-hide-change");
            },
            showNav(){
                this.$dispatch("header-show-change");
                this.navHide["nav-hide"]=false;
                this.navButton["header-btn-hide"]=true;
            }
        },
        components:{

        }
    }
</script>