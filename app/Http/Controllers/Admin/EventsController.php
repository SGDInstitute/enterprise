<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    public function index()
    {
        return view('admin.events.index', [
            'events' => Event::all()
        ]);
    }

    public function show($slug)
    {
        $event = Event::findBySlug($slug);
        return view('admin.events.show', compact('event'));
    }
}
