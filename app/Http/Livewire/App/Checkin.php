<?php

namespace App\Http\Livewire\App;

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
            'user.phone' => Rule::requiredIf(auth()->check() && $this->user->notifications_via === 'phone'),
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
        return view('livewire.app.checkin')
            ->with([
                'position' => $this->position,
            ]);
    }

    public function getPositionProperty()
    {
        if ($this->ticket->isQueued() && ! $this->ticket->isPrinted()) {
            return DB::table('event_badge_queue')->select('id')->where('printed', false)->where('id', '>', $this->ticket->queue)->count();
        }
    }

    public function add()
    {
        $this->validate();

        $this->user->save();
        $this->ticket->addToQueue();

        $this->ticket->refresh();

        $this->emit('notify', ['message' => 'Successfully checked in.', 'type' => 'success']);
    }
}
