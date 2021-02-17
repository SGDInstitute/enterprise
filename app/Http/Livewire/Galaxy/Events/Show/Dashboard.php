<?php

namespace App\Http\Livewire\Galaxy\Events\Show;

use App\Models\Event;
use Livewire\Component;

class Dashboard extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.galaxy.events.show.dashboard')
            ->with([
                'daysLeft' => $this->daysLeft,
            ]);
    }

    public function getDaysLeftProperty()
    {
        if($this->event->hasEnded) {
            return 0;
        }
        if($this->event->hasStarted) {
            return $this->event->end->diffInDays(now());
        }

        return $this->event->start->diffInDays(now());
    }
}
