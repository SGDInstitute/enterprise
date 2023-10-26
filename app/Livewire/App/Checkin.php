<?php

namespace App\Livewire\App;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Checkin extends Component
{
    use AuthorizesRequests;

    public Ticket $ticket;

    public User $user;

    public $event;

    public $editing = false;

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
        return view('livewire.app.checkin');
    }

    public function getPositionProperty()
    {
        if (auth()->check() && isset($this->ticket) && $this->ticket->isQueued() && ! $this->ticket->isPrinted()) {
            return DB::table('event_badge_queue')->select('id')->where('printed', false)->where('id', '<', $this->ticket->queue->id)->count();
        }
    }

    public function add()
    {
        $this->validate();
        $this->user->save();
        $this->ticket->addToQueue();

        $this->dispatch('notify', ['message' => 'Successfully checked in.', 'type' => 'success']);
    }
}
