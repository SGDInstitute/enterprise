<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Filament\Resources\OrderResource\Pages\ViewOrder;
use App\Filament\Resources\OrderResource\RelationManagers\TicketsRelationManager;
use App\Models\Order;
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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

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
                            ->content(fn ($record) => recordLink($record->event, 'events.edit', $record->event->name)),
                        Placeholder::make('creator')
                            ->content(fn ($record) => recordLink($record->user, 'users.edit', $record->user->name)),
                        Placeholder::make('number_of_tickets')
                            ->content(fn ($record) => $record->tickets()->count()),
                        Placeholder::make('confirmation_number')
                            ->content(fn ($record) => $record->formattedConfirmationNumber),
                        Placeholder::make('transaction_id')
                            ->content(fn ($record) => filamentLink(stripeUrl($record->transaction_id), $record->transaction_id)),
                        Placeholder::make('Total Cost')
                            ->content(fn ($record) => $record->formattedAmount),
                        Placeholder::make('created_at')
                            ->content(fn ($record) => $record->created_at->format('M, d Y')),
                        Placeholder::make('paid_at')
                            ->content(fn ($record) => $record->paid_at->format('M, d Y')),
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
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('event.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('tickets')
                    ->formatStateUsing(fn ($state) => count($state))
                    ->label('# Tickets')
                    ->toggleable(),
                IconColumn::make('invoice')
                    ->label('Has Invoice')
                    ->options([
                        '',
                        'heroicon-o-check-circle' => fn ($state): bool => $state !== null,
                    ])
                    ->toggleable(),
                TextColumn::make('formatted_amount')
                    ->label('Amount')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->date()
                    ->toggleable(),
                TextColumn::make('paid_at')
                    ->date()
                    ->toggleable(),
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
            TicketsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'view' => ViewOrder::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->paid();
    }
}
