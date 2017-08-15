<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventOrdersController extends Controller
{
    public function store($slug)
    {
        $event = Event::published()->findBySlug($slug);

        $order = $event->orderTickets(request()->user(), request('tickets'));

        return response()->json([], 201);
    }
}
