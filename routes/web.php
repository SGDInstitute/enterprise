<?php

Route::get('/', function () {
    return view('welcome', [
        'upcomingEvents' => App\Event::published()->upcoming()->get()
    ]);
});

Auth::routes(['verify' => true]);

Route::get('/login/magic', 'Auth\MagicLoginController@show')->name('login.magic');
Route::post('/login/magic', 'Auth\MagicLoginController@sendToken');
Route::get('/login/magic/{token}', 'Auth\MagicLoginController@authenticate');
Route::get('/register/verify/{token}', 'Auth\UserConfirmationController@store');
Route::get('/register/email', 'Auth\UserConfirmationController@create');

Route::get('/events/{slug}', 'EventsController@show');
Route::get('/events/{slug}/policies/{policy}', 'EventsPoliciesController@show');

Route::get('/donations/create', 'DonationsController@create');
Route::view('/donations/create/institute', 'donations.institute');
Route::view('/donations/create/mblgtacc', 'donations.mblgtacc');
Route::get('/donations/create/{event}', 'SponsorshipsController@create');
Route::post('/donations', 'DonationsController@store');
Route::get('/donations/{hash}', 'DonationsController@show');

Route::view('/forms/thank-you', 'forms.thank_you');
Route::get('/forms/{slug}', 'FormsResponsesController@create')->name('forms.create');
Route::post('/forms/{form}/responses', 'FormsResponsesController@store');
Route::get('/responses/{response}/edit', 'ResponsesController@edit');
Route::patch('/responses/{response}', 'ResponsesController@update');

Route::get('/checkin', 'CheckInController');
Route::get('/print/{ids}', 'PrintController');

Route::get('/users/stop-impersonating', 'Admin\ImpersonationController@stopImpersonating')->name('admin.users.stop-impersonating');

Route::get('/changelog', 'HomeController@changelog');
