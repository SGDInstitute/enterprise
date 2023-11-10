<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['order', 'user', 'invitations']))
            ->columns([
                TextColumn::make('order_id')
                    ->formatStateUsing(function (RelationManager $livewire, Ticket $ticket): string {
                        return $livewire->ownerRecord->order_prefix . $ticket->order_id;
                    })
                    ->label('Order ID')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.orders.view', $record->order_id)),
                TextColumn::make('id')
                    ->label('Ticket ID')
                    ->searchable(['tickets.id'])
                    ->sortable(['tickets.id']),
                IconColumn::make('is_paid')
                    ->getStateUsing(fn ($record) => $record->order->isPaid())
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Ticket::INVITED => 'gray',
                        Ticket::UNASSIGNED => 'warning',
                        Ticket::COMPLETE => 'success',
                    })
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user_id ? route('filament.admin.resources.users.view', $record->user_id) : ''),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->default(fn ($record) => $record->invitations->first()?->email)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereRelation('user', 'email', 'like', "%{$search}%")
                            ->orWhereRelation('invitations', 'email', 'like', "%{$search}%");
                    })
                    ->sortable(),
                TextColumn::make('user.pronouns')
                    ->label('Pronouns')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
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
