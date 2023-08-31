<?php

namespace App\Livewire\App\Program;

use App\Models\Event;
use Livewire\Component;

class MySchedule extends Component
{
    public Event $event;

    public function mount()
    {
        $this->event->load('items');
    }

    public function render()
    {
        return view('livewire.app.program.my-schedule');
    }

    public function redirectTo($id)
    {
        $item = $this->event->items->firstWhere('id', $id);

        return redirect()->route('app.program.schedule-item', [$this->event, $item]);
    }
}
