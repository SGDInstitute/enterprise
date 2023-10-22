<?php

namespace App\Livewire\App\Orders;

use App\Models\Order;
use App\Models\Ticket;
use App\Notifications\AcceptInviteReminder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification as Toast;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class TicketsTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Order $order;

    public function table(Table $table): Table
    {
        $unassigned = $this->order->tickets->where('status', Ticket::UNASSIGNED)->values();
        $unassignedCount = $unassigned->count();

        return $table
            ->query(Ticket::where('order_id', $this->order->id)->with('ticketType', 'user', 'invitations'))
            ->columns([
                TextColumn::make('ticketType.name')
                    ->label('Ticket Type')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Ticket::INVITED => 'gray',
                        Ticket::UNASSIGNED => 'warning',
                        Ticket::COMPLETE => 'success',
                    })
                    ->toggleable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->default(fn ($record) => $record->invitations->first()?->email)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereRelation('user', 'email', 'like', "%{$search}%")
                            ->orWhereRelation('invitations', 'email', 'like', "%{$search}%");
                    })
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.pronouns')
                    ->label('Pronouns')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        Ticket::COMPLETE => 'Complete tickets',
                        Ticket::INVITED => 'Invited tickets',
                        Ticket::UNASSIGNED => 'Unassigned tickets',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value']) {
                            Ticket::COMPLETE => $query->filled(), // @todo update all references of "filled"
                            Ticket::INVITED => $query->whereHas('invitations'),
                            Ticket::UNASSIGNED => $query->whereDoesntHave('invitations')->whereNull('user_id'),
                            default => $query,
                        };
                    }),
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
                    ->modalWidth('md')
                    ->action(function (array $data, Ticket $record): void {
                        $record->invite($data['email'], auth()->user());

                        Toast::make()->title('Invited')->send();
                    })
                    ->hidden(fn ($record) => $record->status !== Ticket::UNASSIGNED),
                Action::make('remove-invite')
                    ->action(function (Ticket $record): void {
                        $record->invitations->each->delete();

                        Toast::make()->title('Removed invitation')->send();
                    })
                    ->hidden(fn ($record) => $record->status !== Ticket::INVITED),
                Action::make('remove-user')
                    ->action(function (Ticket $record): void {
                        $record->update(['user_id' => null, 'answers' => null]);

                        Toast::make()->title('Removed user from ticket')->success()->send();
                    })
                    ->hidden(fn ($record) => $record->status !== Ticket::COMPLETE),
                Action::make('remind-invite')
                    ->action(function (Ticket $record) {
                        Notification::route('mail', $record->invitations->first()->email)
                            ->notify(new AcceptInviteReminder($record->invitations->first(), $record));

                        Toast::make()->title('Sent invite reminder')->success()->send();
                    })
                    ->hidden(fn ($record) => $record->status !== Ticket::INVITED),
                Action::make('add-self')
                    ->action(function (Ticket $record) {
                        $record->update(['user_id' => auth()->id()]);
                        Toast::make()->title('Added yourself to ticket.')->success()->send();
                    })
                    ->hidden(fn ($record) => $record->status !== Ticket::UNASSIGNED || $this->order->tickets->pluck('user_id')->contains(auth()->id())),
                DeleteAction::make()
                    ->label('')
                    ->hidden($this->order->isPaid())
                    ->before(fn ($record) => $record->invitations->each->delete()),
            ])
            ->heading('Tickets')
            ->headerActions([
                Action::make('invite-bulk')
                    ->label('Fill unassigned tickets')
                    ->color('gray')
                    ->slideOver()
                    ->modalWidth('md')
                    ->form([
                        ViewField::make('instructions')
                            ->view('livewire.app.orders.partials.invite-bulk-instructions', ['count' => $unassignedCount]),
                        Repeater::make('invitations')
                            ->label('Invitations to send')
                            ->helperText(function ($state) use ($unassignedCount) {
                                $min = count($state);

                                return "{$min} of {$unassignedCount}";
                            })
                            ->simple(
                                TextInput::make('email')
                                    ->email()
                                    ->required(),
                            )
                            ->defaultItems(0)
                            ->reorderable(false)
                            ->maxItems($unassignedCount)
                            ->addActionLabel('Add email'),
                    ])
                    ->action(function ($data) use ($unassigned) {
                        foreach ($data['invitations'] as $index => $email) {
                            $unassigned[$index]->invite($email);
                        }

                        Toast::make()->title('Sent invites to ' . count($data['invitations']) . ' people')->success()->send();
                    })
                    ->hidden($unassignedCount === 0),
                Action::make('remind-bulk')
                    ->label('Remind all invitees')
                    ->color('gray')
                    ->action(function () {
                        $this->order->tickets->where('status', Ticket::INVITED)
                            ->flatMap->invitations
                            ->each(function ($invitation) {
                                Notification::route('mail', $invitation->email)->notify(new AcceptInviteReminder($invitation));
                                $invitation->touch();
                            });
                        Toast::make()->title('Sent bulk invite reminder')->success()->send();
                    })
                    ->hidden($this->order->tickets->where('status', Ticket::INVITED)->count() === 0),
                Action::make('add-ticket')
                    ->label('Add Another Ticket')
                    ->color('gray')
                    ->action(function () {
                        $data = $this->order->tickets->first()->only(['order_id', 'event_id', 'ticket_type_id', 'price_id']);
                        Ticket::create($data);

                        Toast::make()->title('Successfully added a ticket')->success()->send();
                    })
                    ->hidden($this->order->isPaid()),
            ]);
    }

    public function downloadW9()
    {
        return response()->download(public_path('documents/SGD-Institute-W9.pdf'));
    }

    public function render()
    {
        return view('livewire.app.orders.tickets-table');
    }
}
