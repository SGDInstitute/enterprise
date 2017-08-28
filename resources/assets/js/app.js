/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('./forms/bootstrap');

const eventHub = new Vue();

Vue.mixin({
    data: function () {
        return {
            eventHub: eventHub
        }
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('start-order', require('./components/StartOrder.vue'));
Vue.component('login-or-register', require('./components/LoginOrRegister.vue'));
Vue.component('edit-profile', require('./components/EditProfile.vue'));
Vue.component('edit-password', require('./components/EditPassword.vue'));
Vue.component('pay-with-card', require('./components/PayWithCard.vue'));
Vue.component('pay-with-check', require('./components/PayWithCheck.vue'));
Vue.component('download-invoice', require('./components/DownloadInvoice.vue'));
Vue.component('create-invoice-modal', require('./components/CreateInvoiceModal.vue'));
Vue.component('view-invoice-modal', require('./components/ViewInvoiceModal.vue'));

const app = new Vue({
    el: '#app'
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    if (document.getElementsByClassName('hero-bar').length > 0) {
        var $heroBar = $('.hero-bar'),
            heroBottomTop = $heroBar.offset().top - 55;

        $(window).scroll(function () {
            if ($(window).scrollTop() > heroBottomTop) {
                $heroBar.addClass('sticky').css('top', $('.navbar').outerHeight());
                $('body').css('padding-top', $('.navbar').outerHeight() + $heroBar.outerHeight());
            } else {
                $heroBar.removeClass('sticky');
                $('body').css('padding-top', $('.navbar').outerHeight());
            }
        });
    }

    $('div.flash-alert').not('.alert-important').delay(3000).fadeOut(350);
});