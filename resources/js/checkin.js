import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import Toasted from 'vue-toasted';

window._ = require('lodash');

axios.defaults.baseURL = '/';

Vue.http = Vue.prototype.$http = axios;
Vue.config.productionTip = false;

Vue.use(Toasted);
Vue.use(VueRouter);
Vue.component('app', require('./components/genesis/App.vue').default);

const routes = [
    {
        path: '/',
        name: 'home',
        component: require('./components/genesis/Home').default
    },
    {
        path: '/check-in',
        name: 'check-in',
        component: require('./components/genesis/CheckIn').default
    },
    {
        path: '/orders/:number',
        name: 'orders',
        component: require('./components/genesis/Order').default,
        props: true
    },
    {
        path: '/orders/:number/tickets/:hash',
        component: require('./components/genesis/Ticket').default,
        props: true
    },
    {
        path: '/tickets/:hash',
        component: require('./components/genesis/Ticket').default,
        props: true
    },
    {
        path: '*',
        redirect: '/'
    }
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: '#app',
    router
});
