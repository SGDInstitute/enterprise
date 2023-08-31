<?php

namespace App\Livewire\App\Orders;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Start extends Component
{
    public Order $order;

    public $form;

    public function mount()
    {
        $this->buildForm();
    }

    public function render()
    {
        return view('livewire.app.orders.start')
            ->with([
                'checkoutAmount' => $this->checkoutAmount,
                'ticketTypes' => $this->ticketTypes,
            ]);
    }

    public function getCheckoutAmountProperty()
    {
        $checkoutAmount = 0;

        foreach ($this->form as $ticket) {
            $price = $this->ticketTypes->firstWhere('id', $ticket['type_id'])->prices->firstWhere('id', $ticket['price_id']);
            $checkoutAmount += $price->cost * $ticket['amount'];
        }

        return '$' . number_format($checkoutAmount / 100, 2);
    }

    public function getOrderTicketsProperty()
    {
        return $this->order->tickets->groupBy('ticket_type_id');
    }

    public function getTicketTypesProperty()
    {
        return $this->order->event->ticketTypes;
    }

    public function update()
    {
        $this->checkValidation();

        foreach ($this->form as $item) {
            if ($item['amount'] === $item['original']) {
                continue;
            } elseif ($item['amount'] > $item['original']) {
                Ticket::factory()->times($item['amount'] - $item['original'])->create([
                    'order_id' => $this->order->id,
                    'event_id' => $this->order->event_id,
                    'ticket_type_id' => $item['type_id'],
                    'price_id' => $item['price_id'],
                ]);
            } elseif ($item['amount'] < $item['original']) {
                $canDelete = $this->order->tickets->whereNull('user_id')->take($item['original'] - $item['amount']);

                if ($canDelete === null) {
                    $this->dispatch('notify', ['message' => 'Cannot delte a ticket, because they are all filled.', 'type' => 'error']);
                } else {
                    $canDelete->each->delete();
                }
            }
        }

        return redirect()->route('app.orders.show', $this->order);
    }

    private function buildForm()
    {
        $ticketTypes = $this->order->event->ticketTypes->load('prices');

        $this->form = $ticketTypes->map(function ($item) {
            $amount = isset($this->orderTickets[$item->id]) ? $this->orderTickets[$item->id]->count() : 0;
            if ($item->structure === 'flat') {
                $price = $item->prices->first();

                return [
                    'type_id' => $item->id,
                    'price_id' => $price->id,
                    'name' => $price->name,
                    'cost' => $price->cost / 100,
                    'original' => $amount,
                    'amount' => $amount,
                ];
            } elseif ($item->structure === 'scaled-range') {
                $price = $item->prices->first();

                return [
                    'type_id' => $item->id,
                    'price_id' => $price->id,
                    'name' => $price->name,
                    'cost' => $price->cost / 100,
                    'options' => $item->prices->mapWithKeys(
                        fn ($price) => [$price->id => $price->cost / 100]
                    ),
                    'original' => $amount,
                    'amount' => $amount,
                ];
            } else {
                return [
                    'type_id' => $item->id,
                    'price_id' => null,
                    'cost' => null,
                    'original' => $amount,
                    'amount' => $amount,
                ];
            }
        });
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
}
