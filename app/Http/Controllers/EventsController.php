<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $event = Event::whereNotNull('published_at')->where('slug', $slug)->firstOrFail();
        return view('events.show', [
            'event' => $event,
        ]);
    }
}
