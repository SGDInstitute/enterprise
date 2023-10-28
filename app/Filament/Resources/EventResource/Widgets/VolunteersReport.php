<?php

namespace App\Filament\Resources\EventResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class VolunteersReport extends Widget
{
    protected static string $view = 'filament.resources.event-resource.widgets.volunteers-report';

    public ?Model $record = null;

    protected function getViewData(): array
    {
        return [
            'shifts' => $this->record->shifts->load('users'),
        ];
    }
}
