<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class StatsOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getCards(): array
    {
        return [
            Card::make('Days until Event', $this->daysLeft)
                ->icon('heroicon-o-calendar'),
            Card::make('Reservations', $this->reservations->count())
                ->icon('heroicon-o-cursor-click'),
            Card::make('Orders', $this->orders->count())
                ->icon('heroicon-o-currency-dollar'),
            ...$this->ticketCards
        ];
    }

    public function getDaysLeftProperty()
    {
        if ($this->record->hasEnded) {
            return 0;
        }
        if ($this->record->hasStarted) {
            return $this->record->end->diffInDays(now());
        }

        return $this->record->start->diffInDays(now());
    }

    public function getReservationsProperty()
    {
        return Order::forEvent($this->record)->reservations()->with('tickets')->get();
    }

    public function getOrdersProperty()
    {
        return Order::forEvent($this->record)->paid()->with('tickets')->get();
    }

    public function getTicketCardsProperty()
    {
        $reservationTicketTypes = $this->reservations->flatMap->tickets;
        $orderTicketTypes = $this->orders->flatMap->tickets;

        $cards = [];
        foreach ($this->record->ticketTypes as $ticketType) {
            $unpaidTicketsCount = $reservationTicketTypes->where('ticket_type_id', $ticketType->id)->count();
            $paidTicketsCount = $orderTicketTypes->where('ticket_type_id', $ticketType->id)->count();

            $cards[] = Card::make(
                "# {$ticketType->name} Tickets (Unpaid)",
                "$unpaidTicketsCount unpaid / $paidTicketsCount paid"
            )
            ->icon('heroicon-o-ticket');
        }

        return $cards;
    }
}
