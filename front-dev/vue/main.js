import Vue from "vue"
import Router from 'vue-router'

Vue.use(Router);

var router = new Router();

router.map({
    '/news/:page': {
        component: ""
    },
    '/user/:id': {
        component: ""
    },
    '/item/:id': {
        component: ""
    }
});
