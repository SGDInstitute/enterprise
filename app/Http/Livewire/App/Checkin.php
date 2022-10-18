<?php

namespace App\Http\Livewire\App;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Checkin extends Component
{
    use AuthorizesRequests;

    public Ticket $ticket;

    public User $user;

    public $event;

    public $editing = false;

    public function rules() {
        return [
            'user.name' => 'required',
            'user.pronouns' => '',
            'user.notifications_via' => 'required',
            'user.email' => 'required',
            'user.phone' => Rule::requiredIf($this->user->notifications_via === 'phone'),
        ];
    }

    public function mount($ticket = null)
    {
        $this->event = Event::find(8);

        if ($ticket) {
            $this->ticket = $ticket;
            $this->authorize('update', $this->ticket);
            $this->user = $this->ticket->user;
        } elseif (auth()->check()) {
            $ticket = auth()->user()->ticketForEvent($this->event);
            if ($ticket !== null) {
                $this->ticket = $ticket;
                $this->authorize('update', $this->ticket);
                $this->user = $this->ticket->user;
            }
        }
    }

    public function render()
    {
        return view('livewire.app.checkin');
    }

    public function add()
    {
        $this->validate();

        $this->user->save();
        // $this->ticket->addToQueue();

        // $this->ticket->refresh();

        $this->emit('notify', ['message' => 'Successfully checked in.', 'type' => 'success']);
    }
}
