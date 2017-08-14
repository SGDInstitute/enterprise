<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventOrdersController extends Controller
{
    public function store($slug)
    {
        $event = Event::findBySlug($slug);

        $order = $event->orders()->create(['user_id' => request()->user()->id]);

        foreach (range(1, request('ticket_quantity')) as $i) {
            $order->tickets()->create([
                'ticket_type_id' => request('ticket_type')
            ]);
        }

        return response()->json([], 201);
    }
}
