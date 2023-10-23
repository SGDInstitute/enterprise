<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\RelationManagers\DonationsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\ReservationsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\TicketsRelationManager;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                        Section::make()->schema([
                            TextInput::make('name')
                                ->maxLength(255),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255),
                            TextInput::make('pronouns')
                                ->maxLength(255),
                        ])->columnSpan(2),
                        Section::make()->schema([
                            TextInput::make('password')
                                ->password()
                                ->required()
                                ->maxLength(255),
                            TextInput::make('password_confirmation')
                                ->password()
                                ->required()
                                ->maxLength(255),
                        ])->columnSpan(1),
                        Section::make()->schema([
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
                    ->icons([
                        'heroicon-o-x-circle',
                        'heroicon-o-hand-thumb-up' => fn ($state): bool => $state !== null,
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
            TicketsRelationManager::class,
            DonationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
