<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class TicketBreakdown extends Widget
{
    protected static string $view = 'filament.resources.event-resource.widgets.ticket-breakdown';

    public ?Model $record = null;

    public function getReservationsProperty()
    {
        return Order::forEvent($this->record)->reservations()->with('tickets')->get()->flatMap->tickets;
    }

    public function getOrdersProperty()
    {
        return Order::forEvent($this->record)->paid()->with('tickets')->get()->flatMap->tickets;
    }

    public function tablePaidData()
    {
        $rows = [];
        foreach ($this->record->ticketTypes as $ticketType) {
            $rows[] = [
                'ticket-type' => $ticketType->name,
                'reservations' => $this->reservations->where('ticket_type_id', $ticketType->id)->count(),
                'orders' => $this->orders->where('ticket_type_id', $ticketType->id)->count(),
            ];
        }

        return $rows;
    }

    public function tableFilledData()
    {
        $rows = [];
        foreach ($this->record->ticketTypes as $ticketType) {
            $rows[] = [
                'ticket-type' => $ticketType->name,
                'unpaid-unfilled' => $this->reservations->where('ticket_type_id', $ticketType->id)->whereNull('user_id')->count(),
                'paid-unfilled' => $this->orders->where('ticket_type_id', $ticketType->id)->whereNull('user_id')->count(),
                'unpaid-filled' => $this->reservations->where('ticket_type_id', $ticketType->id)->whereNotNull('user_id')->count(),
                'paid-filled' => $this->orders->where('ticket_type_id', $ticketType->id)->whereNotNull('user_id')->count(),
            ];
        }

        return $rows;
    }
}
