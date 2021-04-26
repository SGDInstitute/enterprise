<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Show extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.app.events.show');
    }
}
