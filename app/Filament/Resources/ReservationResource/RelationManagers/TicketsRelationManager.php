<?php

namespace App\Filament\Resources\ReservationResource\RelationManagers;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
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
            ->columns([
                TextColumn::make('id')
                    ->label('Ticket ID')
                    ->searchable(['tickets.id'])
                    ->sortable(['tickets.id']),
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
                    ->disabled(fn ($record) => $record->user_id === null)
                    ->action(fn ($record) => $record->update(['user_id' => null, 'answers' => null])),
            ])
            ->bulkActions([
                //
            ]);
    }
}
