<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingEvents extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Event::where('end', '>=', now());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->url(fn ($record) => EventResource::getUrl('edit', ['record' => $record])),
            TextColumn::make('days_until'),
            TextColumn::make('start')
                ->label('Duration')
                ->formatStateUsing(fn ($record) => $record->formattedDuration),
        ];
    }
}
