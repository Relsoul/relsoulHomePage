<template>
    <div class="admin">
        <div class="row no-gutters">

            <r-header @header-show-change="headerShow" @header-hide-change="headerHide" ></r-header>
            <div class="col s12 m10 right-content" :class="[Contentcls]">
                <nav style="transition:all 0.5s;">
                    <div class="nav-wrapper">
                        <a href="#" v-link="{path:'/admin'}" class="brand-logo">Relsoul后台管理</a>
                        <ul id="nav-mobile" class="right hide-on-med-and-down">
                            <li><a href="#" >首页</a></li>
                            <li><a href="#" v-link="{path:'/admin/user/'}">用户</a></li>
                            <li><a href="#" v-link="{path:'/admin/project/'}" >项目与文章</a></li>
                        </ul>
                    </div>
                </nav>
                444555666
                <router-view></router-view>
            </div>
<!--            <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                <a class="btn-floating btn-large red">
                    <i class="large mdi-editor-mode-edit"></i>
                </a>
                <ul>
                    <li><a class="btn-floating red"><i class="large mdi-editor-insert-chart"></i></a></li>
                    <li><a class="btn-floating yellow darken-1"><i class="large mdi-editor-format-quote"></i></a></li>
                    <li><a class="btn-floating green"><i class="large mdi-editor-publish"></i></a></li>
                    <li><a class="btn-floating blue"><i class="large mdi-editor-attach-file"></i></a></li>
                </ul>
            </div>-->
        </div>

    </div>
</template>
<style>

</style>
<script>
    import rHeader from '../rHeader.vue'
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