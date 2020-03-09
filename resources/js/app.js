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
