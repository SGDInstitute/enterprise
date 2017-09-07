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

use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome', [
        'upcomingEvents' => App\Event::published()->upcoming()->get()
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/events/{slug}', 'EventsController@show');
Route::post('/events/{slug}/orders', 'EventOrdersController@store');

Route::get('/orders/{id}', 'OrdersController@show');
Route::post('/orders/{order}/charge', 'OrderChargeController@store');
Route::post('/orders/{order}/invoices', 'OrderInvoicesController@store');
Route::get('/orders/{order}/receipt', 'OrderReceiptController@show');

Route::get('/invoices/{invoice}', 'InvoicesController@show');
Route::patch('/invoices/{invoice}', 'InvoicesController@update');
Route::get('/invoices/{invoice}/download', 'InvoicesDownloadController@index');
Route::get('/invoices/{invoice}/resend', 'InvoicesResendController@index');

Route::get('/receipts/{receipt}/resend', 'ReceiptsResendController@index');

Route::get('/settings', 'SettingsController@edit');
Route::post('/settings/password', 'SettingPasswordsController@store');

Route::get('/admin', function() {
    return view('admin.index');
});