<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Tickets extends Component
{
    public Event $event;

    public $order;

    public $form;

    public $ticketTypes;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->ticketTypes = $this->event->ticketTypes->load('prices');

        $this->form = $this->ticketTypes
            ->map(function ($item) {
                if ($item->structure === 'flat') {
                    $price = $item->prices->first();

                    return [
                        'type_id' => $item->id,
                        'price_id' => $price->id,
                        'name' => $price->name,
                        'cost' => $price->cost / 100,
                        'amount' => 0,
                    ];
                } elseif ($item->structure === 'scaled-range') {
                    $price = $item->prices->first();

                    return [
                        'type_id' => $item->id,
                        'price_id' => $price->id,
                        'name' => $price->name,
                        'cost' => $price->cost / 100,
                        'options' => $item->prices->mapWithKeys(fn ($price) => [$price->id => $price->cost / 100]),
                        'amount' => 0,
                    ];
                } else {
                    return [
                        'type_id' => $item->id,
                        'price_id' => null,
                        'cost' => null,
                        'amount' => 0,
                    ];
                }
            });
    }

    public function render()
    {
        return view('livewire.app.events.tickets')
            ->with([
                'checkoutButton' => $this->checkoutButton,
                'checkoutAmount' => $this->checkoutAmount,
            ]);
    }

    public function getCheckoutButtonProperty()
    {
        if ($this->order !== null) {
            return auth()->user()->checkout($this->order->ticketsFormattedForCheckout(), [
                'success_url' => route('app.orders.show', ['order' => $this->order, 'success']),
                'cancel_url' => route('app.orders.show', ['order' => $this->order, 'canceled']),
                'billing_address_collection' => 'required',
                'metadata' => [
                    'order_id' => $this->order->id,
                    'event_id' => $this->event->id,
                ],
            ]);
        }
    }

    public function getCheckoutAmountProperty()
    {
        $checkoutAmount = 0;

        foreach ($this->form as $ticket) {
            $price = $this->ticketTypes->firstWhere('id', $ticket['type_id'])->prices->firstWhere('id', $ticket['price_id']);
            if ($price) {
                $checkoutAmount += $price->cost * $ticket['amount'];
            }
        }

        return '$'.number_format($checkoutAmount / 100, 2);
    }

    public function reserve()
    {
        if ($this->order !== null) {
            return redirect()->route('app.orders.show', $this->order);
        }

        $this->checkValidation();

        $reservation = Order::create(['event_id' => $this->event->id, 'user_id' => auth()->id(), 'reservation_ends' => now()->addDays($this->event->settings->reservation_length)]);
        $reservation->tickets()->createMany($this->convertFormToTickets());

        return redirect()->route('app.orders.show', $reservation);
    }

    public function pay()
    {
        $this->checkValidation();

        $this->order = Order::create(['event_id' => $this->event->id, 'user_id' => auth()->id(), 'reservation_ends' => now()->addDays($this->event->settings->reservation_length)]);
        $this->order->tickets()->createMany($this->convertFormToTickets());
    }

    private function checkValidation()
    {
        throw_if($this->form->pluck('amount')->unique()->count() === 1 && $this->form->pluck('amount')->unique()[0] === 0, ValidationException::withMessages([
            'amounts' => ['Please enter the number of tickets.'],
        ]));

        // get ticket types from form that are expired and have amounts greater than zero
        $expiredTypes = $this->ticketTypes->filter(fn ($type) => $type->end->isPast())->pluck('id');
        $invalid = $this->form->filter(fn ($item) => $expiredTypes->contains($item['type_id']))->filter(fn ($item) => $item['amount'] > 0);

        throw_if($invalid->count() > 0, ValidationException::withMessages([
            'amounts' => ['Cannot purchase expired ticket type.'],
        ]));
    }

    private function convertFormToTickets()
    {
        return $this->form->filter(fn ($item) => $item['amount'] > 0)
            ->map(function ($item) {
                $data = [
                    'event_id' => $this->event->id,
                    'ticket_type_id' => $item['type_id'],
                    'price_id' => $item['price_id'],
                ];

                if ($item['amount'] == 1) {
                    $data['user_id'] = auth()->id();
                }

                return Ticket::factory()->times($item['amount'])->make($data);
            })->flatten()->toArray();
    }
}
