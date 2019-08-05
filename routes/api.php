<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/orders/{number}', 'Api\OrdersController@show');
Route::post('/orders/{order}/charge', 'Api\OrderChargeController@store');

Route::get('/tickets/{hash}', 'Api\TicketsController@show');
Route::patch('/tickets/{hash}', 'Api\TicketsController@update');

Route::post('/users/{user}', 'Api\UsersController@store');

Route::post('/donations', 'Api\DonationsController@store');

Route::get('/queue', 'Api\QueueController@index');
Route::post('/queue/{ids}', 'Api\QueueController@store');
Route::patch('/queue/{ids}/complete', 'Api\QueueCompletedController');
