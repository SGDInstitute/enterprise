<?php

namespace App\Http\Controllers;

use App\Event;
use App\Rules\TicketQuantityNotZero;
use Illuminate\Http\Request;

class EventOrdersController extends Controller
{
    public function store($slug)
    {
        request()->validate([
            'tickets' => ['required', new TicketQuantityNotZero],
        ]);

        $event = Event::published()->findBySlug($slug);

        $order = $event->orderTickets(request()->user(), request('tickets'));

        return response()->json(compact('order'), 201);
    }
}
