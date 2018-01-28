<?php

namespace App\Http\Controllers;

use App\Event;

class EventsPoliciesController extends Controller
{
    public function show($slug, $policy)
    {
        $event = Event::published()->findBySlug($slug);

        return view('events.policies.show', [
            'event' => $event,
            'policy' => $policy,
            'attribute' => $policy . '_policy',
        ]);
    }
}
