<?php

namespace App\Http\Livewire\App\Orders;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\AddedToTicket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
{
    use WithPagination;
    use WithFiltering;
    use WithSorting;

    public Order $order;

    public $filters = [
        'search' => '',
    ];

    public $ticketholder = [
        'name' => '',
        'email' => '',
        'pronouns' => '',
    ];

    public $invite = [
        'email' => '',
        'email_confirmation' => '',
    ];

    public $answers;

    public $continue = false;

    public $editingTicket;

    public $editMode = false;

    public $emailChanged = false;

    public $form = [];

    public $perPage = 10;

    public $showInviteModal = false;

    public $showTicketholderModal = false;

    public $ticketsView = 'grid';

    public $updateEmail = false;

    protected $listeners = [
        'refresh' => '$refresh',
        'loadNext' => 'loadNext',
    ];

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
        if ($field === 'ticketholder.email') {
            if ($this->editingTicket->user_id !== null) {
                $this->emailChanged = true;
            }
            if ($user = User::whereEmail($value)->first()) {
                $this->ticketholder['name'] = $user->name;
                $this->ticketholder['pronouns'] = $user->pronouns;
            }
        }
        if (Str::startsWith($field, 'form.') && Str::endsWith($field, '.email')) {
            if ($user = User::whereEmail($value)->first()) {
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

    public function add()
    {
        $data = $this->tickets->first()->only(['order_id', 'event_id', 'ticket_type_id', 'price_id']);
        Ticket::create($data);
        
        $this->emit('notify', ['message' => 'Successfully added a ticket', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function delete($ticketId)
    {
        $ticket = $this->tickets->firstWhere('id', $ticketId);

        if (! auth()->user()->can('delete', $ticket)) {
            return $this->emit('notify', ['message' => 'You cannot delete tickets.', 'type' => 'error']);
        }

        if ($ticket->isFilled()) {
            return $this->emit('notify', ['message' => 'Cannot delete a filled ticket, please remove the user first', 'type' => 'error']);
        }

        $ticket->delete();

        if ($this->order->fresh()->tickets->count() === 0) {
            $this->order->delete();

            return redirect('/dashboard');
        }

        $this->emit('notify', ['message' => 'Successfully deleted ticket', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function enableEditMode()
    {
        $this->editMode = true;
        foreach ($this->tickets as $ticket) {
            $this->form[] = [
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->user->id ?? null,
                'name' => $ticket->user->name ?? '',
                'email' => $ticket->user->email ?? '',
                'pronouns' => $ticket->user->pronouns ?? '',
            ];
        }
    }

    public function inviteAttendee()
    {
        $this->validate(['invite.email' => ['required', 'email', 'confirmed']]);

        $invitation = $this->editingTicket->invitations()->create([
            'invited_by' => auth()->id(),
            'email' => $this->invite['email'],
        ]);

        Notification::route('mail', $this->invite['email'])->notify(new AddedToTicket($this->editingTicket, $invitation, auth()->user()->name));

        $this->reset('editingTicket', 'invite');
    }

    public function loadInvite($id)
    {
        $ticket = $this->tickets->find($id);
        if (! auth()->user()->can('update', $ticket)) {
            return $this->emit('notify', ['message' => 'You cannot edit other tickets.', 'type' => 'error']);
        }

        $this->editingTicket = $ticket;

        $this->showInviteModal = true;
    }

    public function loadAuthUser()
    {
        $this->ticketholder = auth()->user()->only(['name', 'email', 'pronouns']);
    }

    public function loadNext()
    {
        $ticket = $this->tickets->firstWhere('user_id', null);

        if ($ticket !== null) {
            $this->loadTicket($ticket->id);
        }
    }

    public function loadTicket($id)
    {
        $ticket = $this->tickets->find($id);
        if (! auth()->user()->can('update', $ticket)) {
            return $this->emit('notify', ['message' => 'You cannot edit other tickets.', 'type' => 'error']);
        }

        $this->editingTicket = $ticket;
        $this->answers = $this->editingTicket->answers ?? $this->getAnswerForm($this->editingTicket);

        if ($this->editingTicket->user_id !== null) {
            $this->ticketholder = $this->editingTicket->user->only(['name', 'email', 'pronouns']);
        }

        $this->showTicketholderModal = true;
    }

    public function removeUserFromTicket($id)
    {
        $ticket = $this->tickets->find($id);

        if (! auth()->user()->can('update', $ticket)) {
            return $this->emit('notify', ['message' => 'You cannot edit other tickets.', 'type' => 'error']);
        }

        $ticket->update(['user_id' => null, 'answers' => null]);

        $this->emit('refresh');
    }

    public function saveTicket()
    {
        // $this->validate();

        $newUser = false;
        $sendNotification = true;

        if ($this->editingTicket->user_id !== null) {
            $user = $this->editingTicket->user;
            $sendNotification = false;
        }

        if ($this->editingTicket->user_id === null || $this->emailChanged === false) {
            $user = User::whereEmail($this->ticketholder['email'])->first();
            if ($user === null && ! $this->emailChanged) {
                $user = new User;
                $user->email = $this->ticketholder['email'];
                $user->password = Hash::make(Str::random(15));
                $newUser = true;
            }
            $sendNotification = true;
        }

        $user->name = $this->ticketholder['name'];
        $user->pronouns = $this->ticketholder['pronouns'];
        if ($this->emailChanged) {
            $user->email = $this->ticketholder['email'];
        }
        $user->save();

        $this->editingTicket->update([
            'user_id' => $user->id,
            'answers' => $this->answers,
        ]);

        if ($user->id !== auth()->id() && $sendNotification) {
            $user->notify(new AddedToTicket($this->editingTicket, $newUser, auth()->user()->name));
        }

        $this->emit('refresh');
        $this->reset('ticketholder', 'emailChanged', 'emailChanged');

        $this->showTicketholderModal = false;

        if ($this->continue) {
            $this->emit('loadNext');
        }
    }

    public function saveTickets()
    {
        foreach ($this->form as $item) {
            $ticket = $this->tickets->find($item['ticket_id']);

            // skip items that aren't filled
            if ($item['email'] === '') {
                continue;
            }

            // if user was found, fill ticket and update user info
            if ($item['user_id'] !== null || $user = User::where('email', $item['email'])->first()) {
                $ticket->user_id = $item['user_id'] ?? $user->id;
                $ticket->save();
                $ticket->refresh();

                $ticket->user->update([
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'pronouns' => $item['pronouns'],
                ]);

                // if not authenticated user, send notification that they were added to a ticket
                if ($ticket->user_id !== auth()->id()) {
                    $ticket->user->notify(new AddedToTicket($ticket, false, auth()->user()->name));
                }

                continue;
            }

            if ($item['user_id'] === null) {
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

    private function getAnswerForm($ticket)
    {
        if (isset($ticket->ticketType->form)) {
            return $ticket->ticketType->form
                        ->filter(fn ($item) => $item['style'] !== 'content')
                        ->mapWithKeys(function ($item) {
                            if ($item['style'] === 'question') {
                                if ($item['type'] === 'list' && $item['list-style'] === 'checkbox') {
                                    return [$item['id'] => []];
                                }

                                return [$item['id'] => ''];
                            } elseif ($item['style'] === 'collaborators') {
                                return [$item['id'] => auth()->user()->email ?? ''];
                            }
                        })->toArray();
        }
    }
}
