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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
                    ->label('Ticket Type'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Ticket::INVITED => 'gray',
                        Ticket::UNASSIGNED => 'warning',
                        Ticket::COMPLETE => 'success',
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

                        Toast::make()->title('Removed user from ticket')->send();
                    })
                    ->hidden(fn ($record) => $record->status !== Ticket::COMPLETE),
                Action::make('remind-invite')
                    ->action(fn (Ticket $record) => Notification::route('mail', $record->invitations->first()->email)
                            ->notify(new AcceptInviteReminder($record->invitations->first(), $record))
                    )
                    ->hidden(fn ($record) => $record->status !== Ticket::INVITED),
                Action::make('add-self')
                    ->action(fn (Ticket $record) => $record->update(['user_id' => auth()->id()])
                    )
                    ->hidden(fn ($record) => $record->status !== Ticket::UNASSIGNED || $this->order->tickets->pluck('user_id')->contains(auth()->id())),
            ])
            ->headerActions([
                Action::make('invite-bulk')
                    ->label('Fill unassigned tickets')
                    ->slideOver()
                    ->modalWidth('md')
                    ->form([
                        ViewField::make('instructions')
                            ->view('livewire.app.orders.partials.invite-bulk-instructions', ['count' => $unassignedCount]),
                        Repeater::make('invitations')
                            ->label('Invitations to send')
                            ->helperText(function ($state) use ($unassignedCount) {
                                $min = count($state);
                                return "$min of $unassignedCount";
                            })
                            ->simple(
                                TextInput::make('email')
                                    ->email()
                                    ->required(),
                            )
                            ->defaultItems(0)
                            ->reorderable(false)
                            ->maxItems($unassignedCount)
                            ->addActionLabel('Add email')
                    ])
                    ->action(function ($data) use ($unassigned){
                        foreach ($data['invitations'] as $index => $email) {
                            $unassigned[$index]->invite($email);
                        }
                    })
                    ->hidden($unassignedCount === 0)
            ]);
    }

    public function render()
    {
        return view('livewire.app.orders.tickets-table');
    }
}
