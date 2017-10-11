<?php

Route::get('/admin', 'AdminController@index');

Route::get('/admin/events', 'Admin\EventsController@index');
Route::get('/admin/events/{slug}', 'Admin\EventsController@show')->name('admin.events.show');

Route::get('/admin/events/{slug}/orders', 'Admin\EventOrdersController@index');
Route::get('/admin/orders/{id}', 'Admin\OrdersController@show');

Route::get('/admin/users', 'Admin\UsersController@index');
Route::get('/admin/users/{id}', 'Admin\UsersController@show');