<?php

namespace App\Filament\Resources\ShiftResource\Pages;

use App\Filament\Resources\ShiftResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListShifts extends ListRecords
{
    protected static string $resource = ShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_frontend')
                ->modalWidth('sm')
                ->form([
                    Select::make('event')
                        ->options(Event::whereHas('shifts')->pluck('name', 'slug')),
                ])
                ->outlined()
                ->action(fn ($data) => redirect()->route('app.volunteer', $data['event'])),
            Actions\CreateAction::make(),
        ];
    }
}
