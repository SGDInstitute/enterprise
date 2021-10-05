<?php

namespace App\Http\Livewire\App;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Checkin extends Component
{
    use AuthorizesRequests;

    public Ticket $ticket;
    public User $user;
    public $event;

    public $editing = false;

    public $rules = [
        'user.name' => 'required',
        'user.pronouns' => '',
        'user.email' => 'required',
    ];

    public function mount()
    {
        $this->authorize('update', $this->ticket);
        $this->user = $this->ticket->user;
    }

    public function render()
    {
        return view('livewire.app.checkin');
    }

    public function add()
    {
        $this->ticket->addToQueue();

        $this->ticket->refresh();

        $this->emit('notify', ['message' => 'Successfully checked in.', 'type' => 'success']);
    }

    public function save()
    {
        $this->validate();

        $this->user->save();
        $this->ticket->fresh();

        $this->editing = false;

        $this->emit('notify', ['message' => 'Successfully saved changes', 'type' => 'success']);
    }

}
