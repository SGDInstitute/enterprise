<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Actions\CompBulkAction;
use App\Filament\Actions\MarkAsPaidAction;
use App\Filament\Actions\SafeDeleteBulkAction;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationsRelationManager extends RelationManager
{
    protected static string $relationship = 'reservations';

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
                    ->copyable()
                    ->copyMessage('ID copied')
                    ->formatStateUsing(fn ($record) => $record->formattedId)
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tickets')
                    ->formatStateUsing(fn ($state) => count($state))
                    ->label('Number of Tickets'),
                IconColumn::make('invoice')
                    ->label('Has Invoice')
                    ->icons([
                        '',
                        'heroicon-o-check-circle' => fn ($state): bool => $state !== null,
                    ]),
                TextColumn::make('formatted_amount')
                    ->label('Amount'),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('reservation_ends')
                    ->label('Due Date')
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                ViewAction::make()->url(fn ($record) => route('filament.resources.reservations.view', $record)),
                MarkAsPaidAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    CompBulkAction::make(),
                    SafeDeleteBulkAction::make(),
                ]),
            ]);
    }
}
