<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/orders/{number}', 'Api\OrdersController@show');

Route::get('/tickets/{hash}', 'Api\TicketsController@show');
Route::patch('/tickets/{hash}', 'Api\TicketsController@update');

Route::post('/users/{user}', 'Api\UsersController@store');

Route::post('/queue/{ids}', 'Api\QueueController@store');
