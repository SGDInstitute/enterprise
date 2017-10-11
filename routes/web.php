<?php

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

Route::get('/events/{slug}', 'EventsController@show');

Route::get('/donations/create', 'DonationsController@create');
Route::post('/donations', 'DonationsController@store');
Route::get('/donations/{hash}', 'DonationsController@show');