<?php

namespace App\Http\Livewire\App;

use App\Models\Order;
use Livewire\Component;

class OnsiteCheckin extends Component
{
    public $order;

    public $confirmationNumber;

    public $editing;

    public $notFound = false;

    public $user;

    public $rules = [
        'user.name' => 'required',
        'user.pronouns' => '',
        'user.email' => 'required|email',
    ];

    public function render()
    {
        return view('livewire.app.onsite-checkin')
            ->with([
                'hideAddButton' => $this->hideAddButton,
            ]);
    }

    public function getHideAddButtonProperty()
    {
        if ($this->order !== null) {
            $queued = $this->order->tickets->filter(fn ($ticket) => $ticket->isQueued());

            return $queued->count() === $this->order->tickets->count();
        }

        return false;
    }

    public function add()
    {
        $this->order->tickets->each->addToQueue();

        $this->order->refresh();

        $this->hideAddButton = true;
    }

    public function edit($id)
    {
        $this->editing = $this->order->tickets->firstWhere('id', $id);
        $this->user = $this->editing->user;
    }

    public function lookup()
    {
        $order = Order::where('confirmation_number', str_replace(['-', '_', ' '], '', $this->confirmationNumber))
            ->orWhere('id', $this->confirmationNumber)
            ->with(['tickets.user'])
            ->first();

        if ($order === null) {
            $this->notFound = true;
        } else {
            $this->order = $order;
        }
    }

    public function save()
    {
        $this->user->save();

        $this->order->refresh();

        $this->emit('notify', ['message' => 'Successfully saved.', 'type' => 'success']);
        $this->reset('user', 'editing');
    }
}
