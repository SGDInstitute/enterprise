<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Actions\MarkAsUnpaidAction;
use App\Filament\Actions\RefundAction;
use App\Filament\Actions\SafeDeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'paidOrders';

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
            ->recordTitleAttribute('id')
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
                TextColumn::make('tickets_count')
                    ->counts('tickets')
                    ->label('Number of Tickets'),
                IconColumn::make('invoice')
                    ->label('Has Invoice')
                    ->icons([
                        '',
                        'heroicon-o-check-circle' => fn ($state): bool => $state !== null,
                    ]),
                TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('confirmation_number')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('formatted_amount')
                    ->label('Amount'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ViewAction::make()->url(fn ($record) => route('filament.admin.resources.orders.view', $record)),
                MarkAsUnpaidAction::make(),
                RefundAction::make(),
            ])
            ->bulkActions([
                SafeDeleteBulkAction::make(),
            ]);
    }
}
