<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use Livewire\Component;

class Tickets extends Component
{
    public Event $event;
    public $tickets;
    public $formChanged = false;

    public function updating($field)
    {
        if(in_array($field, array_keys($this->rules))) {
            $this->formChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.tickets');
    }
}
