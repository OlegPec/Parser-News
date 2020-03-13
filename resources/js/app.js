/*
require('./bootstrap');

window.Vue = require('vue');

Vue.component('card', require('./components/NewsHomeComponent.vue').default);

import Vue from 'vue';

import axios from 'axios';
import VueAxios from 'vue-axios';
var infiniteScroll =  require('vue-infinite-scroll');

Vue.use(VueAxios, axios);
Vue.use(infiniteScroll);


window.onload = function () {
    const app1 = new Vue({
        el: '#app1',
    });
};
*/


/*new*/
// import axios from 'axios';
// import VueAxios from 'vue-axios';
import Vue from 'vue'
import VueRouter from 'vue-router'
// import infiniteScroll from 'vue-infinite-scroll'
let infiniteScroll =  require('vue-infinite-scroll');
// import Vuex from 'vuex';
// Vue.use(Vuex);
// Vue.use(Vuex);
// Vue.use(VueAxios);
Vue.use(VueRouter);
Vue.use(infiniteScroll);

import App from './views/App'
import Show from './views/Show'
import Home from './views/Home'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/show/:id',
            name: 'show',
            component: Show,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    // render: h => h(App),
});
