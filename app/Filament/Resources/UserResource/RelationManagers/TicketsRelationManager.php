<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['order.event']))
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('order_id')
                    ->formatStateUsing(function (Ticket $record): string {
                        return $record->order->formatted_id;
                    })
                    ->label('Order ID')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.orders.view', $record->order_id)),
                TextColumn::make('event.name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.events.edit', $record->event_id)),
                TextColumn::make('ticketType.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn ($record) => TicketResource::getUrl('view', ['record' => $record])),
                Action::make('remove_user')
                    ->action(fn ($record) => $record->update(['user_id' => null, 'answers' => null])),
            ])
            ->bulkActions([
                //
            ]);
    }
}
