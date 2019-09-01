require('./bootstrap');

window.Vue = require('vue');

import VueTour from 'vue-tour';
require('vue-tour/dist/vue-tour.css');

import Toasted from 'vue-toasted';
Vue.use(Toasted)

import PortalVue from 'portal-vue'
Vue.use(VueTour);
Vue.use(PortalVue)

require('./forms/bootstrap');

const eventHub = new Vue();

Vue.mixin({
    data: function () {
        return {
            eventHub: eventHub
        }
    }
});

require('./components');

const app = new Vue({
    el: '#app'
});

$(function () {
    $('#menu').click(function () {
        $('#nav').toggleClass('hidden');
    });

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

    $('.smooth').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 78
                }, 1000);
                return false;
            }
        }
    });
});

