<?php

namespace App\Filament\Resources\EventResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PresenterCheckIn extends Widget
{
    protected static string $view = 'filament.resources.event-resource.widgets.presenter-check-in';

    public ?Model $record = null;

    protected function getViewData(): array
    {
        return [
            'presenters' => $this->record
                ->proposals()
                ->where('status', 'scheduled')
                ->with('collaborators:id,name,pronouns,email,phone')
                ->get()
                ->flatMap
                ->collaborators
                ->unique('id'),
        ];
    }
}
