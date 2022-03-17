<?php

namespace App\Http\Livewire\App;

use App\Models\Event;
use Livewire\Component;

class Program extends Component
{
    public Event $event;
    public $page;
    public $ticket;

    public function mount($page = 'bulletin-board')
    {
        $this->page = $page;
        $this->ticket = auth()->user()->ticketForEvent($this->event);
    }

    public function render()
    {
        return view('livewire.app.program')
            ->layout('layouts.gemini', ['title' => $this->event->name, 'event' => $this->event])
            ->with([
                'checkedIn' => $this->checkedIn,
            ]);
    }

    public function getCheckedInProperty()
    {
        return $this->ticket->isQueued();
    }
}
