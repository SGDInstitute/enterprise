<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Ticket ID')
                    ->searchable(['tickets.id'])
                    ->sortable(['tickets.id']),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->user_id ? route('filament.resources.users.edit', $record->user_id) : ''),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
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
                Action::make('remove_user')
                    ->disabled(fn ($record) => $record->user_id === null)
                    ->action(fn ($record) => $record->update(['user_id' => null, 'answers' => null])),
            ])
            ->bulkActions([
                //
            ]);
    }
}