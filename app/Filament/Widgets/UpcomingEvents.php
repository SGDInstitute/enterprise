<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingEvents extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Event::where('end', '>=', now()))
            ->columns([
                TextColumn::make('name')
                    ->url(fn ($record) => EventResource::getUrl('edit', ['record' => $record])),
                TextColumn::make('days_until'),
                TextColumn::make('start')
                    ->label('Duration')
                    ->formatStateUsing(fn ($record) => $record->formattedDuration),
            ])
            ->actions([
                Action::make('reports')
                    ->url(fn ($record) => EventResource::getUrl('report', ['record' => $record])),
            ]);
    }
}
