<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Actions\CompBulkAction;
use App\Filament\Actions\MarkAsPaidAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReservationsRelationManager extends RelationManager
{
    protected static string $relationship = 'reservations';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->reservations();
    }

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
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                ViewAction::make(),
                MarkAsPaidAction::make(),
            ])
            ->bulkActions([
                CompBulkAction::make(),
            ]);
    }
}
