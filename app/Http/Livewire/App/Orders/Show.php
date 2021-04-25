<?php

namespace App\Http\Livewire\App\Orders;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination, WithFiltering, WithSorting;

    protected $listeners = ['refresh' => '$refresh'];

    public Order $order;
    public User $ticketholder;

    public $filters = [
        'search' => ''
    ];

    public $continue = false;
    public $editMode = false;
    public $editingTicket;
    public $form = [];
    public $perPage = 10;
    public $ticketsView = 'grid';
    public $showTicketholderModal = false;

    protected $rules = [
        'ticketholder.name' => 'required',
        'ticketholder.email' => 'required',
        'ticketholder.pronouns' => '',
    ];

    public function mount()
    {
        $this->ticketholder = new User;
    }

    public function updated($field, $value)
    {
        if($field === 'ticketholder.email') {
            if($user = User::whereEmail($value)->first()) {
                $this->ticketholder = $user;
            }
        }
        if(Str::startsWith($field, 'form.') && Str::endsWith($field, '.email')) {
            if($user = User::whereEmail($value)->first()) {
                $index = str_replace(['form.', '.email'], '', $field);
                $this->form[$index] = [
                    'ticket_id' => $this->form[$index]['ticket_id'],
                    'user_id' => $user->id ?? null,
                    'name' => $user->name ?? '',
                    'email' => $user->email ?? '',
                    'pronouns' => $user->pronouns ?? '',
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.app.orders.show')
            ->with([
                'filledCount' => $this->filledCount,
                'subtotal' => $this->subtotal,
                'tickets' => $this->tickets,
            ]);
    }

    // Properties

    public function getFilledCountProperty()
    {
        return $this->order->tickets->filter(fn($ticket) => $ticket->isFilled())->count();
    }

    public function getSubtotalProperty()
    {
        $sum = $this->order->tickets->sum(function($ticket) {
            return $ticket->price->cost ?? $ticket->scaled_price;
        });

        return '$' . number_format($sum/100, 2);
    }

    public function getTicketsProperty()
    {
        return Ticket::query()
            ->where('order_id', $this->order->id)
            ->with('price', 'ticketType', 'user')
            ->paginate($this->perPage);
    }

    // Methods

    public function addUser()
    {
        if($this->ticketholder->id === null) {
            $this->ticketholder->password = Hash::make(Str::random(15));
        }
        $this->ticketholder->save();

        $ticket = $this->tickets->firstWhere('user_id', null);
        $ticket->user_id = $this->ticketholder->id;
        $ticket->save();

        $this->emit('refresh');
        $this->ticketholder = new User;

        if(!$this->continue) {
            $this->showTicketholderModal = false;
        }
    }

    public function delete()
    {
        $this->order->delete();
        return redirect('/');
    }

    public function download()
    {
        return response()->download(public_path('documents/SGD-Institute-W9.pdf'));
    }

    public function editUser()
    {
        $this->ticketholder->save();
        $this->showTicketholderModal = false;
        $this->emit('refresh');
        $this->ticketholder = new User;
    }

    public function enableEditMode()
    {
        $this->editMode = true;
        foreach($this->tickets as $ticket) {
            $this->form[] = [
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->user->id ?? null,
                'name' => $ticket->user->name ?? '',
                'email' => $ticket->user->email ?? '',
                'pronouns' => $ticket->user->pronouns ?? '',
            ];
        }
    }

    public function loadAuthUser()
    {
        $this->ticketholder = auth()->user();
    }

    public function loadTicketholder($id)
    {
        $this->editingTicket = $this->tickets->find($id);
        $this->ticketholder = $this->editingTicket->user;
        $this->showTicketholderModal = true;
    }

    public function removeTicketholder($id)
    {
        $ticket = $this->tickets->find($id);

        $ticket->user_id = null;
        $ticket->save();
        $this->emit('refresh');
    }

    public function save()
    {
        foreach($this->form as $item) {
            $ticket = $this->tickets->find($item['ticket_id']);
            $ticket->user_id = $item['user_id'];
            $ticket->save();
            $user = $ticket->user;
            $user->name = $item['name'];
            $user->email = $item['email'];
            $user->pronouns = $item['pronouns'];
            $user->save();
        }

        $this->editMode = false;
    }
}
