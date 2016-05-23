import Vue from "vue"
import Router from 'vue-router'
import App from "./APP.vue";

import Home from "./components/Home/home.vue"
import Admin from "./components/Admin/admin.vue"


Vue.use(Router);

var router = new Router();

router.map({
    '/': {
        component: Home
    },
    "/admin":{
        component:Admin,
        auth:true
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




