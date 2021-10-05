<?php

namespace App\Http\Livewire\App;

use App\Models\Event;
use Livewire\Component;

class Program extends Component
{

    public Event $event;
    public $page;

    public function mount($page = 'bulletin-board')
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.app.program')
            ->layout('layouts.gemini', ['title' => $this->event->name, 'event' => $this->event]);
    }
}
