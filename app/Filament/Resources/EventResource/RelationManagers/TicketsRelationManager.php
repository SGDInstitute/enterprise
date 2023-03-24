<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                TextColumn::make('order_id')
                    ->formatStateUsing(function (RelationManager $livewire, Ticket $record): string {
                        return $livewire->ownerRecord->order_prefix . $record->order_id;
                    })
                    ->label('Order ID')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.resources.orders.view', $record->order_id)),
                TextColumn::make('id')
                    ->label('Ticket ID')
                    ->searchable(['tickets.id'])
                    ->sortable(['tickets.id']),
                IconColumn::make('is_paid')
                    ->getStateUsing(fn ($record) => $record->order->isPaid())
                    ->boolean()
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle'),
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
                    ->action(fn ($record) => $record->update(['user_id' => null, 'answers' => null])),
            ])
            ->bulkActions([
                //
            ]);
    }    
}