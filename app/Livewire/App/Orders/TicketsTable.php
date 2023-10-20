<?php

namespace App\Livewire\App\Orders;

use App\Models\Order;
use App\Models\Ticket;
use App\Notifications\AcceptInviteReminder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification as Toast;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class TicketsTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Order $order;

    public function table(Table $table): Table
    {
        return $table
            ->query(Ticket::where('order_id', $this->order->id)->with('ticketType', 'user', 'invitations'))
            ->columns([
                TextColumn::make('ticketType.name')
                    ->label('Ticket Type'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'invited' => 'gray',
                        'unfilled' => 'warning',
                        'filled' => 'success',
                    }),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->default(fn ($record) => $record->invitations->first()?->email),
                TextColumn::make('user.name')
                    ->label('Name'),
                TextColumn::make('user.pronouns')
                    ->label('Pronouns'),
            ])
            ->filters([
                // Filled
                // Unfilled
                // Invited
            ])
            ->actions([
                Action::make('invite')
                    ->form([
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->confirmed(),
                        TextInput::make('email_confirmation'),
                    ])
                    ->action(function (array $data, Ticket $record): void {
                        $record->invite($data['email'], auth()->user());

                        Toast::make()->title('Invited')->send();
                    })
                    ->hidden(fn ($record) => $record->status !== 'unfilled'),
                Action::make('remove-invite')
                    ->action(function (Ticket $record): void {
                        $record->invitations->each->delete();

                        Toast::make()->title('Removed invitation')->send();
                    })
                    ->hidden(fn ($record) => $record->status !== 'invited'),
                Action::make('remove-user')
                    ->action(function (Ticket $record): void {
                        $record->update(['user_id' => null, 'answers' => null]);

                        Toast::make()->title('Removed user from ticket')->send();
                    })
                    ->hidden(fn ($record) => $record->status !== 'filled'),
                Action::make('remind-invite')
                    ->action(fn (Ticket $record) =>
                        Notification::route('mail', $record->invitations->first()->email)
                            ->notify(new AcceptInviteReminder($record->invitations->first(), $record))
                    )
                    ->hidden(fn ($record) => $record->status !== 'invited'),
                Action::make('add-self')
                    ->action(fn (Ticket $record) =>
                        $record->update(['user_id' => auth()->id()])
                    )
                    ->hidden(fn ($record) => $record->status !== 'unfilled')
            ])
            ->headerActions([
                // Invite
            ]);
    }

    public function render()
    {
        return view('livewire.app.orders.tickets-table');
    }
}
