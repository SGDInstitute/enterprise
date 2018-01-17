
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./forms/bootstrap');

require('bootstrap-sass');

require('metismenu');
require('jquery-slimscroll');
require('../vendor/inspinia/js/inspinia');
require('../vendor/selectWoo/js/selectWoo.full.js');
require('../vendor/datatables/datatables');

let pace = require('pace');
pace.start();

window.Vue = require('vue');

// require('./forms/bootstrap');

import {Tabs, Tab} from 'vue-tabs-component';

Vue.component('tabs', Tabs);
Vue.component('tab', Tab);
Vue.component('mark-as-paid-modal', require('./components/admin/MarkAsPaidModal.vue'));
Vue.component('reports', require('./components/admin/Reports.vue'));

const app = new Vue({
    el: '#wrapper',
    data: {
        showMarkAsPaidModal: false
    }
});

$(document).ready(function(){
    $('.selectWoo').selectWoo({
        tags: true
    });

    $('.dataTables').DataTable();
});