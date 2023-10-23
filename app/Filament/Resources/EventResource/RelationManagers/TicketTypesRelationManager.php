<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\TicketTypeResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TicketTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'ticketTypes';

    protected static ?string $recordTitleAttribute = 'name';

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['prices']))
            ->columns(TicketTypeResource::columns())
            ->headerActions([
                CreateAction::make()
                    ->url(fn ($livewire) => route('filament.admin.resources.ticket-types.create', ['event_id' => $livewire->ownerRecord->id])),
            ])
            ->actions([
                EditAction::make()
                    ->url(fn ($record) => route('filament.admin.resources.ticket-types.edit', $record)),
            ]);
    }
}
