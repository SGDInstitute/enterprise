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

Route::get('/login/magic', 'Auth\MagicLoginController@show')->name('login.magic');
Route::post('/login/magic', 'Auth\MagicLoginController@sendToken');
Route::get('/login/magic/{token}', 'Auth\MagicLoginController@authenticate');
Route::get('/register/verify/{token}', 'Auth\UserConfirmationController@store');
Route::get('/register/email', 'Auth\UserConfirmationController@create');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/events/{slug}', 'EventsController@show');
Route::post('/events/{slug}/orders', 'EventOrdersController@store');

Route::get('/orders/{id}', 'OrdersController@show');
Route::delete('/orders/{order}', 'OrdersController@destroy');
Route::post('/orders/{order}/charge', 'OrderChargeController@store');
Route::post('/orders/{order}/invoices', 'OrderInvoicesController@store');
Route::get('/orders/{order}/receipt', 'OrderReceiptController@show');
Route::patch('/orders/{order}/tickets', 'OrderTicketsController@update');
Route::patch('/tickets/{hash}', 'TicketsController@update');

Route::get('/invoices/{invoice}', 'InvoicesController@show');
Route::patch('/invoices/{invoice}', 'InvoicesController@update');
Route::get('/invoices/{invoice}/download', 'InvoicesDownloadController@index');
Route::get('/invoices/{invoice}/resend', 'InvoicesResendController@index');

Route::get('/receipts/{receipt}/resend', 'ReceiptsResendController@index');

Route::get('/donations/create', 'DonationsController@create');
Route::post('/donations', 'DonationsController@store');
Route::get('/donations/{hash}', 'DonationsController@show');

Route::get('/settings', 'SettingsController@edit');
Route::post('/settings/password', 'SettingPasswordsController@store');
Route::patch('/profile/{user?}', 'ProfileController@update');

Route::get('/users/stop-impersonating', 'Admin\ImpersonationController@stopImpersonating')->name('admin.users.stop-impersonating');