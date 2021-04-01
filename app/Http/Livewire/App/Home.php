<?php

namespace App\Http\Livewire\App;

use App\Models\Event;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.app.home')
            ->layout('layouts.app', ['title' => ''])
            ->with([
                'events' => $this->events
            ]);
    }

    public function getEventsProperty()
    {
        return Event::all();
    }
}
