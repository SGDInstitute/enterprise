<?php

Route::get('/home', 'HomeController@index')->name('home');

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

Route::get('/settings', 'SettingsController@edit');
Route::post('/settings/password', 'SettingPasswordsController@store');
Route::patch('/profile/{user?}', 'ProfileController@update');