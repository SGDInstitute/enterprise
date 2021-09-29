<?php

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/events/{event}/schedule', function (Event $event) {
    return $event->items->whereNull('parent_id')->each(function($item) {
        $item->title = $item->name;
        $item->start = $item->start->timezone($item->timezone);
        $item->end = $item->end->timezone($item->timezone);
        $item->backgroundColor = '#07807b';
        $item->borderColor = '#07807b';
    });
});
