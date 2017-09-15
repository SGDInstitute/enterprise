<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventOrdersController extends Controller
{
    public function index($slug)
    {
        $event = Event::findBySlug($slug);

        return view('admin.events.orders.index', [
            'orders' => $event->orders,
            'event' => $event,
        ]);
    }
}
