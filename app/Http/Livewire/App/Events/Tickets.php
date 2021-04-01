<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Tickets extends Component
{

    public Event $event;
    public $tickets;

    protected $rules = [
        'tickets.*.amount' => 'required',
    ];

    public function mount()
    {
        $this->tickets = $this->event->ticketTypes;
    }

    public function render()
    {
        return view('livewire.app.events.tickets')
            ->with([
                'formattedAmount' => $this->formattedAmount,
            ]);
    }

    public function getFormattedAmountProperty()
    {
        $amount = $this->tickets->sum(function ($ticket) {
            if ($ticket->amount) {
                return $ticket->cost * $ticket->amount;
            }
            return 0;
        });

        return '$' . number_format($amount / 100, 2);
    }
}
