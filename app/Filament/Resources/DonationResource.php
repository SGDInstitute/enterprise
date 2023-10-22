<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages\ListDonations;
use App\Filament\Resources\DonationResource\Pages\ViewDonation;
use App\Models\Donation;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_id')
                    ->required(),
                TextInput::make('parent_id'),
                TextInput::make('transaction_id')
                    ->maxLength(255),
                TextInput::make('subscription_id')
                    ->maxLength(255),
                TextInput::make('amount')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('next_bill_date'),
                DateTimePicker::make('ends_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('usd')
                    ->sortable(),
                TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => ListDonations::route('/'),
            'view' => ViewDonation::route('/{record}'),
        ];
    }
}
