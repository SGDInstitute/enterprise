<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
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
        $event = Event::whereNotNull('published_at')
            ->whereDate('published_at', '<', Carbon::now())
            ->where('slug', $slug)->firstOrFail();
        return view('events.show', [
            'event' => $event,
        ]);
    }
}
