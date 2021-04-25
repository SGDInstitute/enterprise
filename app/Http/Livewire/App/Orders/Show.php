<?php

namespace App\Http\Livewire\App\Orders;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
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
    public $invoice = [];
    public $perPage = 10;
    public $ticketsView = 'grid';
    public $showCheckModal = false;
    public $showInvoiceModal = false;
    public $showTicketholderModal = false;

    protected $rules = [
        'ticketholder.name' => 'required',
        'ticketholder.email' => 'required',
        'ticketholder.pronouns' => '',
        'order.invoice.billable' => '',
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
                'checkout' => $this->checkout,
                'filledCount' => $this->filledCount,
                'subtotal' => $this->order->subtotal,
                'tickets' => $this->tickets,
                'progressSteps' => $this->progressSteps,
                'progressCurrent' => $this->progressSteps->firstWhere('complete', false),
            ]);
    }

    // Properties

    public function getCheckoutProperty()
    {
        return auth()->user()->checkout($this->order->ticketsFormattedForCheckout(), [
            'success_url' => route('app.orders.show', ['order' => $this->order, 'success']),
            'cancel_url' => route('app.orders.show', ['order' => $this->order, 'canceled']),
            'billing_address_collection' => 'required',
            'metadata' => [
                'order_id' => $this->order->id,
            ]
        ]);
    }

    public function getFilledCountProperty()
    {
        return $this->order->tickets->filter(fn($ticket) => $ticket->isFilled())->count();
    }

    public function getProgressStepsProperty()
    {
        return collect([
            ['name' => 'Create Reservation', 'complete' => true],
            ['name' => 'Pay', 'complete' => $this->order->isPaid(), 'help' => 'app.help.pay'],
            ['name' => 'Add Folks to Tickets', 'complete' => $this->order->isFilled(), 'help' => 'app.help.tickets'],
            ['name' => 'Get Ready', 'complete' => false],
        ]);
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

    public function createInvoice()
    {
        $this->order->generateInvoice();
        $this->invoice = $this->order->invoice;
        $this->showInvoiceModal = true;
    }

    public function delete()
    {
        $this->order->delete();
        return redirect('/');
    }

    public function downloadInvoice()
    {
        $this->saveInvoice();

        $pdf = PDF::loadView('pdf.invoice', ['order' => $this->order])->output();
        $filename = 'Invoice-' . $this->order->formattedId . '.pdf';
        return response()->streamDownload(fn() => print($pdf), $filename);
    }

    public function downloadW9()
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

            // skip items that aren't filled
            if($item['email'] === '')
                continue;

            // if user was found, fill ticket and update user info
            if($item['user_id'] !== null || $user = User::where('email', $item['email'])->first()) {
                $ticket->user_id = $item['user_id'] ?? $user->id;
                $ticket->save();

                $ticket->fresh()->user->update([
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'pronouns' => $item['pronouns'],
                ]);
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
                continue;
            }
        }

        $this->emit('notify', ['message' => 'Successfully saved ticket changes', 'type' => 'success']);

        $this->emit('refresh');
        $this->editMode = false;
    }

    public function saveInvoice()
    {
        $this->order->save();
        $this->emit('notify', ['message' => 'Successfully saved invoice details.', 'type' => 'success']);
    }
 }
