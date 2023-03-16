<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Filament\Resources\EventResource\Widgets\StatsOverview;
use App\Filament\Resources\EventResource\Widgets\TicketBreakdown;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.events.pages.view-event';

    protected function getHeaderWidgetsColumns(): int | array
    {
        return 3;
    }

    protected function getActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            TicketBreakdown::class,
        ];
    }
}
