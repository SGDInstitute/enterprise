<?php

namespace App\Http\Livewire\Galaxy\Events\Show;

use App\Models\Event;
use App\Models\Order;
use Livewire\Component;

class Dashboard extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.galaxy.events.show.dashboard')
            ->with([
                'daysLeft' => $this->daysLeft,
                'reservations' => $this->reservations->count(),
                'orders' => $this->orders->count(),
                'tickets' => $this->tickets
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

    public function getReservationsProperty()
    {
        return Order::forEvent($this->event)->reservations()->with('tickets')->get();
    }

    public function getOrdersProperty()
    {
        return Order::forEvent($this->event)->paid()->with('tickets')->get();
    }

    public function getTicketsProperty()
    {
        $reservationTicketTypes = $this->reservations->flatMap->tickets;
        $orderTicketTypes = $this->orders->flatMap->tickets;

        $tickets = [];
        foreach($this->event->ticketTypes as $ticketType) {
            $tickets[] = [
                'ticketType' => $ticketType,
                'reservations_count' => $reservationTicketTypes->where('ticket_type_id', $ticketType->id)->count(),
                'orders_count' => $orderTicketTypes->where('ticket_type_id', $ticketType->id)->count(),
            ];
        }

        return $tickets;
    }
}
