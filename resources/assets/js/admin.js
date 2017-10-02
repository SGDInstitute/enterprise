
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('metismenu');
require('jquery-slimscroll');
require('../vendor/inspinia/js/inspinia');
require( 'datatables.net-bs' )();
let pace = require('pace');
pace.start();

$(document).ready(function(){
    $('.datatables').DataTable();
});