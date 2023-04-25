<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Livewire\Component;

class Show extends Component
{
    public Event $event;

    public $guide =  [
        'num_tickets' => 1,
        'is_attending' => null,
        'payment' => null,
    ];

    public $showPreviousOrders = false;
    public $showGuide = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        if (request()->query('edit')) {
            // @todo check if user is authorized to view
            $this->load(request()->query('edit'));
        } else {
            if ($this->previousOrders->count() > 0) {
                $this->showPreviousOrders = true;
            } else {
                $this->showGuide = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.app.events.show', [
            'steps' => $this->steps,
            'previousOrders' => $this->previousOrders,
        ]);
    }

    public function getPreviousOrdersProperty()
    {
        if (auth()->check()) {
            return auth()->user()->orders()->where('event_id', $this->event->id)->get();
        }

        return collect([]);
    }

    public function getStepsProperty()
    {
        return [
            ['title' => 'Add/Delete Tickets', 'complete' => false, 'current' => true],
            ['title' => 'Pay Now or Get Invoice', 'complete' => false, 'current' => false],
            ['title' => 'Assign Tickets', 'complete' => false, 'current' => false],
        ];
    }

    public function generate()
    {
        $this->validate([
            'guide.num_tickets' => ['required', 'integer', 'min:1'],
            'guide.is_attending' => ['required', 'boolean'],
            'guide.payment' => ['required', 'boolean'],
        ], attributes: [
            'guide.num_tickets' => 'number of tickets',
            'guide.is_attending' => '"are you attending"',
            'guide.payment' => 'payment method',
        ]);

        $reservation = Order::create(['event_id' => $this->event->id, 'user_id' => auth()->id(), 'reservation_ends' => now()->addDays($this->event->reservationEndsAt)]);
        $reservation->tickets()->createMany($this->convertFormToTickets());

        return redirect()->route('app.orders.show', $reservation);
    }

    public function showGuideModal()
    {
        $this->showPreviousOrders = false;
        $this->showGuide = true;
    }

    private function convertFormToTickets()
    {
        // @todo handle if more than one type of ticket option
        $ticketType = $this->event->ticketTypes()->where('end', '>', now())->get()->first();

        $data = [
            'event_id' => $this->event->id,
            'ticket_type_id' => $ticketType->id,
            'price_id' => $ticketType->prices->first()->id,
        ];

        $tickets = [];
        foreach (range(1, $this->guide['num_tickets']) as $count) {
            if ($this->guide['is_attending'] == true && $count === 1) {
                $tickets[] = array_merge(['user_id' => auth()->id()], $data);
            } else {
                $tickets[] = $data;
            }
        }

        return $tickets;
    }

    private function load($id)
    {
        $this->order = $this->previousOrders->firstWhere('id', $id);
        $this->tickets = $this->order->tickets;
    }
}
