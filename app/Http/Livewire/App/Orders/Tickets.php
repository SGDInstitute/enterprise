<?php

namespace App\Http\Livewire\App\Orders;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\AddedToTicket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
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
        return view('livewire.app.orders.tickets')
            ->with([
                'tickets' => $this->tickets,
            ]);
    }

    // Properties

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
        $newUser = false;
        if($this->ticketholder->id === null) {
            $this->ticketholder->password = Hash::make(Str::random(15));
            $newUser = true;
        }
        $this->ticketholder->save();

        $ticket = $this->tickets->firstWhere('user_id', null);
        $ticket->user_id = $this->ticketholder->id;
        $ticket->save();

        if($this->ticketholder->id !== auth()->id()) {
            $this->ticketholder->notify(new AddedToTicket($ticket, $newUser, auth()->user()->name));
        }

        $this->emit('refresh');
        $this->ticketholder = new User;

        if(!$this->continue) {
            $this->showTicketholderModal = false;
        }
    }

    public function cancelTicketModal()
    {
        $this->ticketholder = new User;
        $this->showTicketholderModal = false;
    }

    public function editUser()
    {
        $this->ticketholder->save();
        $this->emit('refresh');
        $this->ticketholder = new User;
        if(!$this->continue) {
            $this->showTicketholderModal = false;
        }
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

            // skip items that aren't filled
            if($item['email'] === '')
                continue;

            // if user was found, fill ticket and update user info
            if($item['user_id'] !== null || $user = User::where('email', $item['email'])->first()) {
                $ticket->user_id = $item['user_id'] ?? $user->id;
                $ticket->save();
                $ticket->refresh();

                $ticket->user->update([
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'pronouns' => $item['pronouns'],
                ]);

                // if not authenticated user, send notification that they were added to a ticket
                if($ticket->user_id !== auth()->id()) {
                    $ticket->user->notify(new AddedToTicket($ticket, false, auth()->user()->name));
                }

                continue;
            }

            if($item['user_id'] === null) {
                $user = User::create([
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'pronouns' => $item['pronouns'],
                    'password' => Hash::make(Str::random(16)),
                ]);

                $ticket->user_id = $user->id;
                $ticket->save();

                // send notification that they were created and added to a ticket
                $user->notify(new AddedToTicket($ticket, true, auth()->user()->name));
                continue;
            }
        }

        $this->emit('notify', ['message' => 'Successfully saved ticket changes', 'type' => 'success']);

        $this->emit('refresh');
        $this->editMode = false;
    }

 }
