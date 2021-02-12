<?php

namespace App\Http\Livewire\Galaxy\Events;

use App\Models\Event;
use Livewire\Component;

class Create extends Component
{
    public Event $event;
    public $formChanged = false;
    public $preset;

    public $rules = [
        'event.name' => 'required',
        'event.start' => 'required',
        'event.end' => 'required',
        'event.location' => '',
        'event.order_prefix' => '',
        'event.description' => 'required',
        'event.settings' => ''
    ];

    public function mount() {
        $this->event = new Event;
    }

    public function render()
    {
        return view('livewire.galaxy.events.create')
            ->layout('layouts.galaxy', ['title' => 'Create an Event']);
    }

}
