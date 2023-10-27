<?php

namespace App\Livewire\App;

use App\Models\Event;
use App\Models\EventBadgeQueue;
use App\Models\Ticket;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class Checkin extends Component implements HasForms
{
    use AuthorizesRequests;
    use InteractsWithForms;

    public Ticket $ticket;

    public User $user;

    public $event;

    public ?array $data = [];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($ticket = null)
    {
        if ($ticket) {
            $this->authorize('update', $ticket);

            $this->ticket = $ticket->load('event', 'order', 'user');
            $this->event = $this->ticket->event;
            $this->user = $this->ticket->user;
        } elseif (auth()->check()) {
            $this->event = Event::where('end', '>=', now())->first();
            $ticket = auth()->user()->ticketForEvent($this->event);

            if ($ticket !== null) {
                $this->authorize('update', $ticket);
                $this->ticket = $ticket;
                $this->user = $this->ticket->user;
            }
        }

        $this->form->fill($this->user->only(['name', 'pronouns', 'notifications_via', 'email', 'phone']));
    }

    public function render()
    {
        return view('livewire.app.checkin', [
            'partial' => $this->partial,
        ]);
    }

    public function getPartialProperty()
    {
        if (! auth()->check()) {
            return 'need-to-login';
        } elseif ($this->ticket === null) {
            return 'need-ticket';
        } elseif ($this->ticket->order->isReservation()) {
            return 'unpaid-ticket';
        } elseif ($this->ticket->isQueued()) {
            return 'in-queue';
        }

        return 'add-to-queue';
    }

    public function getPositionProperty()
    {
        if ($this->partial === 'in-queue' && ! $this->ticket->isPrinted()) {
            return EventBadgeQueue::where('printed', false)->where('id', '<', $this->ticket->queue->id)->count();
        }
    }

    public function add()
    {
        $data = collect($this->form->getState())->except('name-badge-info', 'notifications-contact-info');
        $this->user->update($data->toArray());
        $this->ticket->addToQueue();

        Notification::make()
            ->success()
            ->title('Successfully checked in')
            ->body('You will receive an when your name badge is ready')
            ->send();

        $this->dispatch('refresh');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Name Badge')
                        ->schema([
                            ViewField::make('name-badge-info')
                                ->view('livewire.app.checkin.name-badge-info'),
                            TextInput::make('name')->required(),
                            TextInput::make('pronouns'),
                        ]),
                    Step::make('Notifications & Contact')
                        ->schema([
                            ViewField::make('notifications-contact-info')
                                ->view('livewire.app.checkin.notifications-contact-info'),
                            CheckboxList::make('notifications_via')
                                ->label('How would you like to receive notifications?')
                                ->helperText('Notifications may include schedule changes, important updates, and survey invitations.')
                                ->options([
                                    'mail' => 'Email',
                                    'vonage' => 'SMS Texts',
                                ])
                                ->required()
                                ->live(),
                            TextInput::make('email')
                                ->email()
                                ->required(),
                            TextInput::make('phone')
                                ->mask('(999) 999-9999')
                                ->required(fn (Get $get) => in_array('vonage', $get('notifications_via')))
                                ->tel(),
                        ]),
                ])->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                    <x-filament::button type="submit" size="sm">
                        Submit
                    </x-filament::button>
                BLADE))),
            ])
            ->statePath('data');
    }
}
