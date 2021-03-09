<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use Livewire\Component;
use App\Models\TicketType;
use Illuminate\Support\Str;

class Tickets extends Component
{
    public Event $event;
    public $ticketTypes;
    public $formChanged = false;

    public $rules = [
        'ticketTypes.*.type' => '',
        'ticketTypes.*.name' => '',
        'ticketTypes.*.description' => '',
        'ticketTypes.*.cost' => '',
        'ticketTypes.*.num_tickets' => '',
        'ticketTypes.*.start' => '',
        'ticketTypes.*.end' => '',
    ];

    public function mount()
    {
        $this->ticketTypes = $this->event->ticketTypes;
    }

    public function updating($field)
    {
        if(Str::startsWith($field, 'ticketTypes')) {
            $this->formChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.tickets');
    }

    public function add()
    {
        $this->ticketTypes[] = new TicketType(['event_id' => $this->event->id, 'name' => 'New Ticket Type']);
        $this->formChanged = true;
    }

    public function remove($index)
    {
        $this->ticketTypes->forget($index);
        $this->formChanged = true;
    }

    public function save()
    {
        $this->ticketTypes->each(function($type) {
            $type->event_id = $this->event->id;
            $type->save();
        });
        $this->formChanged = false;
    }
}
