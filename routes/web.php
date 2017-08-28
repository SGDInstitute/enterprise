<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/events/{slug}', 'EventsController@show');
Route::post('/events/{slug}/orders', 'EventOrdersController@store');

Route::get('/orders/{id}', 'OrdersController@show');
Route::post('/orders/{order}/charge', 'OrderChargeController@store');
Route::get('/orders/{order}/invoices', 'OrderInvoicesController@show');
Route::post('/orders/{order}/invoices', 'OrderInvoicesController@store');

Route::get('/settings', 'SettingsController@edit');
Route::post('/settings/password', 'SettingPasswordsController@store');

Route::get('/admin', function() {
    return view('admin.index');
});