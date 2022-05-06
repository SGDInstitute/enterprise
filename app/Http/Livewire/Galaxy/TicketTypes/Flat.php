<?php

namespace App\Http\Livewire\Galaxy\TicketTypes;

use App\Http\Livewire\Traits\WithFormBuilder;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Flat extends Component
{
    use WithFormBuilder;

    public Event $event;

    public $ticketType = [
        'name' => '',
        'costInDollars' => '',
        'formattedStart' => '',
        'formattedEnd' => '',
    ];

    public $rules = [
        'ticketType.name' => 'required',
        'ticketType.costInDollars' => 'required',
        'ticketType.formattedStart' => 'required',
        'ticketType.formattedEnd' => 'required',
    ];

    public function mount()
    {
        $this->event = Event::find(request()->get('event'));
        $this->ticketType['formattedStart'] = now('America/Chicago')->format('m/d/Y g:i A');
        $this->ticketType['formattedEnd'] = now('America/Chicago')->format('m/d/Y g:i A');
    }

    public function render()
    {
        return view('livewire.galaxy.ticket-types.flat')
            ->layout('layouts.galaxy', ['title' => 'Create Flat Ticket Type']);
    }

    public function save()
    {
        $data = $this->validate()['ticketType'];

        TicketType::createFlatWithStripe([
            'event_id' => $this->event->id,
            'timezone' => $timezone = $this->event->timezone,
            'name' => $data['name'],
            'start' => Carbon::parse($data['formattedStart'], $timezone)->timezone('UTC'),
            'end' => Carbon::parse($data['formattedEnd'], $timezone)->timezone('UTC'),
        ], $data['costInDollars'] * 100);

        return redirect()->route('galaxy.events.edit', ['event' => $this->event, 'page' => 'tickets']);
    }
}
