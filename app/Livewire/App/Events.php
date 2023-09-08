<?php

namespace App\Livewire\App;

use App\Models\Event;
use Livewire\Component;

class Events extends Component
{
    public function render()
    {
        return view('livewire.app.events')
            ->layout('layouts.app', ['title' => 'Events'])
            ->with([
                'events' => $this->events,
            ]);
    }

    public function getEventsProperty()
    {
        return Event::where('end', '>=', now())->get();
    }
}
