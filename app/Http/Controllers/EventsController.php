<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function show($slug)
    {
        $event = Event::published()->with('ticket_types')->findBySlug($slug);
        $ticketTypes = $event->ticket_types->filter(function ($type) use ($event) {
            return $type->type === 'regular';
        });

        if (auth()->check()) {
            $ticketTypes = $ticketTypes->merge(auth()->user()->discounts()->where('event_id', $event->id)->get());
        }

        return view('events.show', [
            'event' => $event,
            'ticket_types' => $ticketTypes,
        ]);
    }
}
