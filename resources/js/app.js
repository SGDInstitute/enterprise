require('./bootstrap');

window.Popper = require('popper.js').default;
require('bootstrap');

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

import {Tabs, Tab} from 'vue-tabs-component';

Vue.component('tabs', Tabs);
Vue.component('tab', Tab);

Vue.component('add-user-button', require('./components/AddUserToTicketButton.vue'));
Vue.component('donation-form', require('./components/DonationForm.vue'));
Vue.component('edit-profile', require('./components/EditProfile.vue'));
Vue.component('edit-password', require('./components/EditPassword.vue'));
Vue.component('invoice-button', require('./components/InvoiceButton.vue'));
Vue.component('invoice-form', require('./components/InvoiceForm.vue'));
Vue.component('invite-users-form', require('./components/InviteUsersForm.vue'));
Vue.component('login-or-register', require('./components/LoginOrRegister.vue'));
Vue.component('manual-user-modal', require('./components/ManualUserModal.vue'));
Vue.component('modal-button', require('./components/ModalButton.vue'));
Vue.component('pay-with-card', require('./components/PayWithCard.vue'));
Vue.component('pay-with-check', require('./components/PayWithCheck.vue'));
Vue.component('receipt-button', require('./components/ReceiptButton.vue'));
Vue.component('remove-user-button', require('./components/RemoveUserButton.vue'));
Vue.component('start-order', require('./components/StartOrder.vue'));
Vue.component('view-invoice-modal', require('./components/ViewInvoiceModal.vue'));
Vue.component('view-receipt-modal', require('./components/ViewReceiptModal.vue'));
Vue.component('view-profile-modal', require('./components/ViewProfileModal.vue'));

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