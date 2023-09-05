<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers\TicketsRelationManager;
use App\Models\Reservation;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Section::make('Details')->schema([
                        Placeholder::make('id')
                            ->label('ID')
                            ->content(fn ($record) => $record->formattedId),
                        Placeholder::make('event')
                            ->content(fn ($record) => filamentLink(EventResource::getUrl('edit', ['record' => $record->event]), $record->event->name)),
                        Placeholder::make('creator')
                            ->content(fn ($record) => filamentLink(UserResource::getUrl('edit', ['record' => $record->user]), $record->user->name)),
                        Placeholder::make('number_of_tickets')
                            ->content(fn ($record) => $record->tickets()->count()),
                        Placeholder::make('Total Cost')
                            ->content(fn ($record) => $record->formattedAmount),
                        Placeholder::make('created_at')
                            ->content(fn ($record) => $record->created_at->format('M, d Y')),
                        Placeholder::make('due_date')
                            ->content(fn ($record) => $record->reservation_ends->format('M, d Y')),
                        Placeholder::make('invoice')
                            ->content(fn ($record) => $record->invoice !== null ? 'Yes' : 'No'),
                    ])->inlineLabel()->columnSpan(1),
                    Section::make('Invoice')->schema([
                        Placeholder::make('name')
                            ->content(fn ($record) => $record->invoice['name']),
                        Placeholder::make('email')
                            ->content(fn ($record) => $record->invoice['email']),
                        Placeholder::make('address')
                            ->content(fn ($record) => $record->formattedAddress),
                    ])->inlineLabel()->hidden(fn ($record) => $record->invoice === null)->columnSpan(1),
                ]),
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
                    ->label('Creator')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('event.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
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
                    ->date()
                    ->sortable(),
                TextColumn::make('reservation_ends')
                    ->label('Due Date')
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
            TicketsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'view' => Pages\ViewReservation::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->reservations();
    }
}
