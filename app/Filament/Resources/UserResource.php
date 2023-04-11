<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\DonationsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\ReservationsRelationManager;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Card::make()->schema([
                            TextInput::make('name')
                                ->maxLength(255),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255),
                            TextInput::make('pronouns')
                                ->maxLength(255),
                        ])->columnSpan(2),
                        Card::make()->schema([
                            TextInput::make('password')
                                ->password()
                                ->required()
                                ->maxLength(255),
                            TextInput::make('password_confirmation')
                                ->password()
                                ->required()
                                ->maxLength(255),
                        ])->columnSpan(1),
                        Card::make()->schema([
                            TextInput::make('address.line1'),
                            TextInput::make('address.line2'),
                            TextInput::make('address.city'),
                            TextInput::make('address.state'),
                            TextInput::make('address.zip'),
                            TextInput::make('address.country'),
                        ])->columns(2)->columnSpan(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('name')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('email')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('pronouns'),
                IconColumn::make('email_verified_at')
                    ->options([
                        'heroicon-o-x-circle',
                        'heroicon-o-thumb-up' => fn ($state): bool => $state !== null,
                    ]),
                TextColumn::make('created_at')
                    ->date(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrdersRelationManager::class,
            ReservationsRelationManager::class,
            DonationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
