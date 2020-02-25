<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class SponsorshipsController extends Controller
{
    public function create($slug)
    {
        $event = Event::published()->findBySlug($slug);

        return view('donations.event', [
            'event' => $event->load('contributions'),
        ]);
    }
}
