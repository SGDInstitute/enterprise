<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function show($slug)
    {
        $event = Event::published()->findBySlug($slug);
        return view('events.show', [
            'event' => $event,
        ]);
    }
}
