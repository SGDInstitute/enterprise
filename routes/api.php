<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/events', function (Request $request) {
    return \App\Event::all()->each(function($event) {
        $event->logo_light = url(Storage::url($event->logo_light));
    });
});

Route::get('/orders/{number}', function (Request $request, $number) {
    $number = str_replace(['_', '-'], '', $number);
    return \App\Order::where('confirmation_number', $number)->with(['tickets.user.profile', 'receipt'])->firstOrFail();
});
