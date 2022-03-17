<?php

use App\Models\Event;
use App\Models\EventBadgeQueue;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/events/{event}/schedule', function (Event $event) {
    return $event->items->whereNull('parent_id')->values()->each(function ($item) {
        $item->title = $item->name;
        $item->start = $item->start->timezone($item->timezone);
        $item->end = $item->end->timezone($item->timezone);
        $item->backgroundColor = '#07807b';
        $item->borderColor = '#07807b';
    });
});

Route::middleware('auth:sanctum')->get('/events/{event}/my-schedule', function (Event $event) {
    return request()->user()->schedule()
        ->where('event_id', $event->id)
        ->get()
        ->each(function ($item) {
            $item->title = $item->name;
            $item->start = $item->start->timezone($item->timezone);
            $item->end = $item->end->timezone($item->timezone);
            $item->backgroundColor = '#07807b';
            $item->borderColor = '#07807b';
        });
});

Route::get('/queue', function () {
    return EventBadgeQueue::where('printed', false)->select('ticket_id', 'user_id', 'name', 'pronouns')->get();
});

Route::post('/queue/{ticket}/printed', function ($ticket) {
    return EventBadgeQueue::where('ticket_id', $ticket)->first()->markAsPrinted();
});
