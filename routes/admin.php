<?php

Route::get('/', 'DashboardController@index');

Route::get('/events', 'EventsController@index');
Route::get('/events/{slug}', 'EventsController@show')->name('admin.events.show');

Route::get('/events/{slug}/orders', 'EventOrdersController@index');
Route::get('/orders/{id}', 'OrdersController@show');

Route::get('/users', 'UsersController@index');
Route::get('/users/{id}', 'UsersController@show')->name('admin.users.show');

Route::get('/roles', 'RolesController@index');
