<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/me', 'Api\UsersController@show');
Route::post('/users', 'Api\RegisterController@register');

Route::get('/events/{event}/ticket-types', 'Api\EventTicketTypeController');

Route::get('/orders/{number}', 'Api\OrdersController@show');
Route::post('/orders/{order}/charge', 'Api\OrderChargeController@store');
Route::post('/orders/{order}/tickets', 'Api\OrderTicketsController@store');

Route::get('/tickets/{hash}', 'Api\TicketsController@show');
Route::patch('/tickets/{hash}', 'Api\TicketsController@update');

Route::post('/users/{user}', 'Api\UsersController@store');

Route::post('/donations', 'Api\DonationsController@store')->middleware('auth:api');

Route::get('/queue', 'Api\QueueController@index');
Route::post('/queue/{ids}', 'Api\QueueController@store');
Route::patch('/queue/{ids}/complete', 'Api\QueueCompletedController');


Route::get('/gemini/schedules', 'Api\Gemini\SchedulesController@index')->middleware('auth:api');
Route::get('/gemini/schedules/{id}', 'Api\Gemini\SchedulesController@show')->middleware('auth:api');
Route::get('/gemini/event/{id}/activities', 'Api\Gemini\EventActivitiesController@index')->middleware('auth:api');
