"use strict";
import Vue from "vue"
import Router from 'vue-router'
import App from "./APP.vue"
import {tokenAjax,promiseAjax} from "./service/ajax"
// 挂载tokenAjax
$.tokenAjax=tokenAjax;
$.promiseAjax=promiseAjax;

import Home from "./components/Home/home.vue"
import Admin from "./components/Admin/admin.vue"
import adminHome from "./components/Admin/adminHome.vue"


Vue.use(Router);

var router = new Router();

router.map({
    '/': {
        component: Home
    },
    "/admin":{
        name: 'admin',
        component:Admin,
        auth:true,
        subRoutes:{
            "/":{
                component:adminHome
            }
        }
    }
});



router.beforeEach(function (transition) {
    if(transition.to.xxx){
        //判断用户是否有权限访问本页面
        if(window.localStorage.getItem("token")&&window.localStorage.getItem("name")){
            $.tokenAjax("/admin/me","get").then((data)=>{
                console.log(91,data);
                if(data.result.role>=10){
                    transition.next();
                };
            }).catch((error)=>{
                transition.redirect("/");
            })
        }else{
            transition.redirect("/");
        };
    }else{
        transition.next();
    }
});

router.start(App,"#app");

$('.button-collapse').sideNav({
        menuWidth: 300, // Default is 240
        edge: 'right', // Choose the horizontal origin
        closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
    }
);


if($(document).width()>420){
    $("body").addClass("body-content-show");
}else{

}


$(document).on({
    dragleave:function(e){    //拖离
        e.preventDefault();
    },
    drop:function(e){  //拖后放
        e.preventDefault();
    },
    dragenter:function(e){    //拖进
        e.preventDefault();
    },
    dragover:function(e){    //拖来拖去
        e.preventDefault();
    }
});







