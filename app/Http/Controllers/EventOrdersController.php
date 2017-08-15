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

        foreach (request('tickets') as $type => $quantity) {
            foreach (range(1, $quantity) as $i) {
                $order->tickets()->create([
                    'ticket_type_id' => $type
                ]);
            }
        }

        return response()->json([], 201);
    }
}
