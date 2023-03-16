<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('event_id')
                    ->required(),
                TextInput::make('user_id')
                    ->required(),
                TextInput::make('confirmation_number')
                    ->maxLength(255),
                TextInput::make('transaction_id')
                    ->maxLength(255),
                TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                TextInput::make('amount')
                    ->maxLength(255),
                DateTimePicker::make('reservation_ends'),
                TextInput::make('invoice'),
                DateTimePicker::make('paid_at'),
            ]);
    }

    public static function table(Table $table): Table
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
                    ->label('# Tickets'),
                IconColumn::make('invoice')
                    ->label('Has Invoice')
                    ->options([
                        '',
                        'heroicon-o-check-circle' => fn ($state): bool => $state !== null,
                    ]),
                TextColumn::make('formatted_amount')
                    ->label('Amount'),
                TextColumn::make('created_at')
                    ->date(),
                TextColumn::make('paid_at')
                    ->date(),
            ])
            ->defaultSort('paid_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
