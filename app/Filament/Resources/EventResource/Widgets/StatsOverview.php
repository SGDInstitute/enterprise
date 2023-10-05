<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class StatsOverview extends BaseWidget
{
    public ?Model $record = null;

    protected int|string|array $columnSpan = 2;

    public function getDaysLeftProperty()
    {
        return $this->record->daysUntil;
    }

    public function getReservationsProperty()
    {
        return Order::forEvent($this->record)->reservations()->with('tickets')->get();
    }

    public function getOrdersProperty()
    {
        return Order::forEvent($this->record)->paid()->with('tickets')->get();
    }

    public function getReservationTotalsProperty()
    {
        $reservationTickets = $this->reservations->flatMap->tickets->count();

        return "{$this->reservations->count()} ({$reservationTickets} tickets)";
    }

    public function getOrderTotalsProperty()
    {
        $orderTickets = $this->orders->flatMap->tickets->count();

        return "{$this->orders->count()} ({$orderTickets} tickets)";
    }

    public function getPotentialMoneyProperty()
    {
        return '$' . number_format($this->reservations->sum('subtotalInCents') / 100, 2);
    }

    public function getMoneyMadeProperty()
    {
        return '$' . number_format($this->orders->sum('amount') / 100, 2);
    }

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getCards(): array
    {
        return [
            Stat::make('Days until Event', $this->daysLeft)->extraAttributes([
                'class' => 'col-span-2',
            ]),
            Stat::make('Reservations', $this->reservationTotals),
            Stat::make('Orders', $this->orderTotals),
            Stat::make('Potential Money from Reservations', $this->potentialMoney),
            Stat::make('Money Made from Orders', $this->moneyMade),
        ];
    }
}
