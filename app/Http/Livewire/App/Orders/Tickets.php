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

    public $filters = [
        'search' => ''
    ];

    public $ticketholder = [
        'name' => '',
        'email' => '',
        'pronouns' => '',
    ];
    public $answers;
    public $continue = false;
    public $editMode = false;
    public $editingTicket;
    public $form = [];
    public $emailChanged = false;
    public $perPage = 10;
    public $ticketsView = 'grid';
    public $showTicketholderModal = false;
    public $updateEmail = null;

    protected $rules = [
        'ticketholder.name' => 'required',
        'ticketholder.email' => 'required',
        'ticketholder.pronouns' => '',
    ];

    public function mount()
    {
        $this->editingTicket = $this->tickets->first();
        $this->answers = $this->editingTicket->answers ?? $this->getAnswerForm($this->editingTicket);
    }

    public function updated($field, $value)
    {
        if($field === 'ticketholder.email') {
            if($this->editingTicket->user_id !== null) {
                $this->emailChanged = true;
            }
            if($user = User::whereEmail($value)->first()) {
                $this->ticketholder['name'] = $user->name;
                $this->ticketholder['pronouns'] = $user->pronouns;
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
                'fillable' => $this->fillable,
            ]);
    }

    // Properties

    public function getFillableProperty()
    {
        return auth()->check();
    }

    public function getTicketsProperty()
    {
        return Ticket::query()
            ->where('order_id', $this->order->id)
            ->with('price', 'ticketType', 'user')
            ->paginate($this->perPage);
    }

    // Methods

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
        $this->ticketholder = auth()->user()->only(['name', 'email', 'pronouns']);
    }

    public function loadTicket($id)
    {
        $this->editingTicket = $this->tickets->find($id);
        $this->answers = $this->editingTicket->answers ?? $this->getAnswerForm($this->editingTicket);

        if($this->editingTicket->user_id !== null) {
            $this->ticketholder = $this->editingTicket->user->only(['name', 'email', 'pronouns']);
        }

        $this->showTicketholderModal = true;
    }

    public function removeUserFromTicket($id)
    {
        $ticket = $this->tickets->find($id);

        $ticket->user_id = null;
        $ticket->save();
        $this->emit('refresh');
    }

    public function saveTicket()
    {
        $newUser = false;
        $sendNotification = true;

        if($this->editingTicket->user_id !== null) {
            $user = $this->editingTicket->user;
            $sendNotification = false;
        }

        if($this->editingTicket->user_id === null || $this->updateEmail === false) {
            $user = User::whereEmail($this->ticketholder['email'])->first();
            if($user === null && !$this->updateEmail) {
                $user = new User;
                $user->email = $this->ticketholder['email'];
                $user->password = Hash::make(Str::random(15));
                $newUser = true;
            }
            $sendNotification = true;
        }
        $user->name = $this->ticketholder['name'];
        $user->pronouns = $this->ticketholder['pronouns'];
        if($this->updateEmail) {
            $user->email = $this->ticketholder['email'];
        }
        $user->save();

        $this->editingTicket->user_id = $user->id;
        $this->editingTicket->answers = $this->answers;
        $this->editingTicket->save();

        if($user->id !== auth()->id() && $sendNotification) {
            $user->notify(new AddedToTicket($this->editingTicket, $newUser, auth()->user()->name));
        }

        $this->emit('refresh');
        $this->reset('ticketholder', 'updateEmail', 'emailChanged');

        if(!$this->continue) {
            $this->showTicketholderModal = false;
        }
    }

    public function saveTickets()
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

    private function getAnswerForm($ticket) {
        return $ticket->ticketType->form
                    ->filter(fn($item) => $item['style'] !== 'content')
                    ->mapWithKeys(function($item) {
                        if($item['style'] === 'question') {
                            if($item['type'] === 'list' && $item['list-style'] === 'checkbox') {
                                return [$item['id'] => []];
                            }

                            return [$item['id'] => ''];
                        } elseif($item['style'] === 'collaborators') {
                            return [$item['id'] => auth()->user()->email ?? ''];
                        }
                    })->toArray();
    }
 }
