<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Tickets extends Component
{

    public Event $event;
    public $ticketTypes;
    public $tickets;

    public function mount()
    {
        $this->ticketTypes = $this->event->ticketTypes->load('prices');
        $this->tickets = $this->ticketTypes->map(function($item) {
            if($item->structure === 'flat') {
                $price = $item->prices->where('start', '<', now())->where('end', '>', now())->first();
                return [
                    'type_id' => $item->id,
                    'price_id' => $price->id,
                    'name' => $price->name,
                    'cost' => $price->cost/100,
                    'amount' => 0,
                ];
            } elseif($item->structure === 'scaled-range') {
                $price = $item->prices->first();
                return [
                    'type_id' => $item->id,
                    'price_id' => $price->id,
                    'name' => $price->name,
                    'cost' => $price->min/100,
                    'min' => $price->min/100,
                    'max' => $price->max/100,
                    'step' => $price->step,
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
                'checkoutAmount' => $this->checkoutAmount,
            ]);
    }

    public function getCheckoutAmountProperty()
    {
        $checkoutAmount = 0;

        foreach($this->tickets as $ticket) {
            $checkoutAmount += $ticket['cost'] * $ticket['amount'];
        }

        return '$' . number_format($checkoutAmount, 2);
    }

    public function reserve()
    {

        dd('passed');
    }
}
