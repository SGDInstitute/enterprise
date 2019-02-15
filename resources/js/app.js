require('./bootstrap');

window.Popper = require('popper.js').default;
require('bootstrap');

window.Vue = require('vue');

import VueTour from 'vue-tour';
require('vue-tour/dist/vue-tour.css');
Vue.use(VueTour);

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

Vue.component('add-user-button', require('./components/AddUserToTicketButton.vue').default);
Vue.component('donation-form', require('./components/DonationForm.vue').default);
Vue.component('edit-profile', require('./components/EditProfile.vue').default);
Vue.component('edit-password', require('./components/EditPassword.vue').default);
Vue.component('invoice-button', require('./components/InvoiceButton.vue').default);
Vue.component('invoice-form', require('./components/InvoiceForm.vue').default);
Vue.component('invite-users-form', require('./components/InviteUsersForm.vue').default);
Vue.component('login-or-register', require('./components/LoginOrRegister.vue').default);
Vue.component('manual-user-modal', require('./components/ManualUserModal.vue').default);
Vue.component('modal-button', require('./components/ModalButton.vue').default);
Vue.component('pay-with-card', require('./components/PayWithCard.vue').default);
Vue.component('pay-with-check', require('./components/PayWithCheck.vue').default);
Vue.component('receipt-button', require('./components/ReceiptButton.vue').default);
Vue.component('remove-user-button', require('./components/RemoveUserButton.vue').default);
Vue.component('start-order', require('./components/StartOrder.vue').default);
Vue.component('update-card-button', require('./components/UpdateCardButton.vue').default);
Vue.component('view-invoice-modal', require('./components/ViewInvoiceModal.vue').default);
Vue.component('view-receipt-modal', require('./components/ViewReceiptModal.vue').default);
Vue.component('view-profile-modal', require('./components/ViewProfileModal.vue').default);
Vue.component('dynamic-form', require('./components/voyager/DynamicForm.vue').default);

Vue.component('pay-tour', require('./components/PayTour.vue').default);
Vue.component('invite-tour', require('./components/InviteTour.vue').default);

const app = new Vue({
    el: '#app'
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    if (document.getElementsByClassName('hero-bar').length > 0) {
        var $heroBar = $('.hero-bar'),
            heroBottomTop = $heroBar.offset().top - 35;

        $(window).scroll(function () {
            if ($(window).scrollTop() > heroBottomTop) {
                $heroBar.addClass('sticky-top').css('top', $('.navbar').outerHeight());
                $('body').css('padding-top', $('.navbar').outerHeight() + $heroBar.outerHeight());
            } else {
                $heroBar.removeClass('sticky-top');
                $('body').css('padding-top', $('.navbar').outerHeight());
            }
        });
    }

    $('div.flash-alert').not('.alert-important').delay(3000).fadeOut(350);

    $('.smooth').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 78
                }, 1000);
                return false;
            }
        }
    });
});
