<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\TicketTypeResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;

class TicketTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'ticketTypes';

    protected static ?string $recordTitleAttribute = 'name';

    public static function table(Table $table): Table
    {
        return $table
            ->columns(TicketTypeResource::columns())
            ->headerActions([
                CreateAction::make()
                    ->url(fn ($livewire) => route('filament.resources.ticket-types.create', ['event_id' => $livewire->ownerRecord->id])),
            ])
            ->actions([
                EditAction::make()
                    ->url(fn ($record) => route('filament.resources.ticket-types.edit', $record)),
            ]);
    }    
}
