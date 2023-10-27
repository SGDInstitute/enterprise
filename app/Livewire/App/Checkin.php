<?php

namespace App\Livewire\App;

use App\Models\Event;
use App\Models\EventBadgeQueue;
use App\Models\Ticket;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Checkin extends Component
{
    use AuthorizesRequests;

    public Ticket $ticket;

    public User $user;

    public $event;

    protected $listeners = ['refresh' => '$refresh'];

    public function rules()
    {
        return [
            'user.name' => 'required',
            'user.pronouns' => '',
            'user.notifications_via' => 'required',
            'user.email' => 'required',
            'user.phone' => Rule::requiredIf(in_array('vonage', $this->user->notifications_via ?? [])),
        ];
    }

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
        $this->validate();
        $this->user->save();
        $this->ticket->addToQueue();

        Notification::make()
            ->success()
            ->title('Successfully checked in')
            ->body('You will receive an when your name badge is ready')
            ->send();

        $this->dispatch('refresh');
    }
}
