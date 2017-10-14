<?php

Route::get('/', 'DashboardController@index')->name('admin.dashboard');

Route::get('/events', 'EventsController@index')->name('admin.events');
Route::get('/events/{slug}', 'EventsController@show')->name('admin.events.show');

Route::get('/events/{slug}/orders', 'EventOrdersController@index')->name('admin.eventOrders');
Route::get('/orders/{id}', 'OrdersController@show')->name('admin.orders.show');


Route::get('/users/access/create', 'UsersAccessController@create')->name('admin.users.access.create');
Route::post('/users/access', 'UsersAccessController@store')->name('admin.users.access.store');
Route::get('/users/{user}/access/edit', 'UsersAccessController@edit')->name('admin.users.access.edit');
Route::patch('/users/{user}/access', 'UsersAccessController@update')->name('admin.users.access.update');

Route::get('/users', 'UsersController@index')->name('admin.users');
Route::get('/users/{id}', 'UsersController@show')->name('admin.users.show');

Route::get('/roles', 'RolesController@index')->name('admin.roles');
Route::get('/roles/create', 'RolesController@create')->name('admin.roles.create');
Route::post('/roles', 'RolesController@store')->name('admin.roles.store');
Route::get('/roles/{role}/edit', 'RolesController@edit')->name('admin.roles.edit');
Route::patch('/roles/{role}', 'RolesController@update')->name('admin.roles.update');

Route::get('/permissions/create', 'PermissionsController@create')->name('admin.permissions.create');
Route::post('/permissions', 'PermissionsController@store')->name('admin.permissions.store');
Route::get('/permissions/{permission}/edit', 'PermissionsController@edit')->name('admin.permissions.edit');
Route::patch('/permissions/{permission}', 'PermissionsController@update')->name('admin.permissions.update');

Route::get('/users/{id}/impersonate', 'ImpersonationController@impersonate')->name('admin.user.impersonate');