<?php

Route::get('/admin', 'AdminController@index');

Route::get('/admin/events', 'Admin\EventsController@index');
Route::get('/admin/events/{slug}', 'Admin\EventsController@show');