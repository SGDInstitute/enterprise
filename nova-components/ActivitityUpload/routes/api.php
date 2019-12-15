<?php

use App\Events\ActivititesUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::post('/upload', function (Request $request) {
    $path = $request->file('file')->store('nova');

    event(new ActivititesUploaded($path));
});
