<?php

namespace App\Filament\Resources\EventResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class TicketFormOverview extends Widget
{
    protected static string $view = 'filament.resources.event-resource.widgets.ticket-form-overview';

    public ?Model $record = null;

    public function getStats(): array
    {
        $answers = $this->record->tickets->whereNotNull('answers')->pluck('answers');
        $keys = $this->record->ticketTypes->pluck('form')->map->pluck('id')->flatten()->unique();

        $stats = [];
        foreach ($keys as $key) {
            $stats[$key] = $answers->pluck($key)->flatten()->countBy();
        }

        return $stats;
    }

    protected function getColumns(): int
    {
        return 2;
    }
}
