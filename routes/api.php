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


Route::get('/gemini/me', 'Api\Gemini\UsersController@show')->middleware('auth:api');
Route::patch('/gemini/me', 'Api\Gemini\UsersController@update')->middleware('auth:api');
Route::get('/gemini/me/activities', 'Api\Gemini\UsersActivitiesController@index')->middleware('auth:api');
Route::post('/gemini/me/activities/{id}', 'Api\Gemini\UsersActivitiesController@store')->middleware('auth:api');
Route::get('/gemini/events/{event}/activities', 'Api\Gemini\EventsActivitiesController@index')->middleware('auth:api');
Route::get('/gemini/events/{event}/bulletins', 'Api\Gemini\EventsBulletinsController@index')->middleware('auth:api');
Route::get('/gemini/events/{event}/content', 'Api\Gemini\EventsContentController@index')->middleware('auth:api');
Route::get('/gemini/events/{event}/evaluations', 'Api\Gemini\EventsEvaluationsController@index')->middleware('auth:api');
Route::get('/gemini/events/{event}/locations', 'Api\Gemini\EventsLocationsController@index')->middleware('auth:api');
Route::get('/gemini/events/{event}/schedules', 'Api\Gemini\EventsSchedulesController@index')->middleware('auth:api');
Route::get('/gemini/events/{event}/schedules/{id}', 'Api\Gemini\EventsSchedulesController@show')->middleware('auth:api');
Route::post('/gemini/tickets', 'Api\Gemini\TicketsController@store')->middleware('auth:api');
