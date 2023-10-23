<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages\ListTickets;
use App\Filament\Resources\TicketResource\Pages\ViewTicket;
use App\Models\Ticket;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make(['default' => 1, 'sm' => 2])
                    ->schema([
                        Section::make('Information')
                            ->columnSpan(1)
                            ->columns(3)
                            ->schema([
                                TextEntry::make('order_id')
                                    ->url(fn (Ticket $record): string => OrderResource::getUrl('view', ['record' => $record->order_id])),
                                TextEntry::make('event.name')
                                    ->url(fn (Ticket $record): string => EventResource::getUrl('edit', ['record' => $record->event_id])),
                                TextEntry::make('ticketType.name'),
                                TextEntry::make('user.name')
                                    ->label('User\'s Name')
                                    ->url(fn (Ticket $record) => $record->user_id ? UserResource::getUrl('edit', ['record' => $record->user_id]) : null)
                                    ->default('No user assigned'),
                                TextEntry::make('user.email')
                                    ->label('Email')
                                    ->hidden(fn (Ticket $record) => $record->status !== Ticket::COMPLETE)
                                    ->copyable(),
                                TextEntry::make('user.pronouns')
                                    ->label('Pronouns')
                                    ->hidden(fn (Ticket $record) => $record->status !== Ticket::COMPLETE),
                                TextEntry::make('invitations.email')
                                    ->hidden(fn (Ticket $record) => $record->status === Ticket::COMPLETE)
                                    ->default('No email invited')
                            ]),
                        Section::make('Answers')
                            ->columnSpan(1)
                            ->hidden(fn (Ticket $record) => $record->answers === null)
                            ->schema(fn (Ticket $record) => $record->answers->map(fn ($item, $id) => TextEntry::make("answers.{$id}")->label($id))->toArray()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListTickets::route('/'),
            'view' => ViewTicket::route('/{record}'),
        ];
    }
}
