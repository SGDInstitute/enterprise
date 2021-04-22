<?php

namespace App\Http\Livewire\Galaxy\TicketTypes;

use App\Models\Event;
use App\Models\Price;
use App\Models\TicketType;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Form extends Component
{
    public $prices;
    public Event $event;
    public $ticketType;
    public $formattedStart;
    public $formattedEnd;

    public $rules = [
        'ticketType.name' => 'required',
        'ticketType.description' => '',
        'ticketType.structure' => 'required',
    ];

    public function mount()
    {
        if($this->ticketType !== null) {
            $this->setUpEditForm();
        } else {
            $this->setUpCreateForm();
        }
    }

    public function render()
    {
        if($this->ticketType->id === null) {
            $title = 'Create Ticket Type for ' . $this->event->name;
        } else {
            $title = 'Edit Ticket Type for ' . $this->event->name;
        }

        return view('livewire.galaxy.ticket-types.form')
            ->layout('layouts.galaxy', ['title' => $title]);
    }

    public function addPrice()
    {
        $this->prices[] = ['name' => '', 'costInDollars' => '0', 'formattedStart' => now($this->event->timezone)->format('m/d/Y g:i A'), 'formattedEnd' => now($this->event->timezone)->format('m/d/Y g:i A')];
    }

    public function removePrice($index)
    {
        unset($this->prices[$index]);
        $this->prices = $this->prices->values();
    }

    public function save()
    {
        $this->ticketType->event_id = $this->event->id;
        $this->ticketType->timezone = $this->event->timezone;
        if($this->ticketType->structure === 'flat') {
            $this->ticketType->start = Carbon::parse(min(array_column($this->prices, 'formattedStart')), $this->ticketType->timezone)->timezone('UTC');
            $this->ticketType->end = Carbon::parse(max(array_column($this->prices, 'formattedEnd')), $this->ticketType->timezone)->timezone('UTC');
        } else {
            $this->ticketType->start = Carbon::parse($this->formattedStart, $this->ticketType->timezone)->timezone('UTC');
            $this->ticketType->end = Carbon::parse($this->formattedEnd, $this->ticketType->timezone)->timezone('UTC');
        }
        $this->ticketType->save();

        [$existing, $creating] = $this->preparePrices($this->prices)->partition(function ($i) {
            return isset($i['id']);
        });

        foreach($existing as $item) {
            Price::where('id', $item['id'])->update($item);
        }
        $this->ticketType->prices()->createMany($creating);

        return redirect()->route('galaxy.events.edit', ['event' => $this->event, 'page' => 'tickets']);
    }

    public function setUpCreateForm()
    {
        $this->event = Event::find(request()->get('event'));
        $this->ticketType = new TicketType(['event_id' => request()->get('event') ?? null, 'structure' => '']);
        $this->prices[] = ['name' => '', 'costInDollars' => '0', 'formattedStart' => now('America/Chicago')->format('m/d/Y g:i A'), 'formattedEnd' => now('America/Chicago')->format('m/d/Y g:i A')];
        $this->formattedStart = now('America/Chicago')->format('m/d/Y g:i A');
        $this->formattedEnd = now('America/Chicago')->format('m/d/Y g:i A');
    }

    public function setUpEditForm()
    {
        $this->ticketType = TicketType::find($this->ticketType)->load('event', 'prices');
        $this->event = $this->ticketType->event;
        $this->formattedStart = $this->ticketType->formattedStart;
        $this->formattedEnd = $this->ticketType->formattedEnd;

        foreach($this->ticketType->prices as $price) {
            $this->prices[] = [
                'id' => $price->id,
                'name' => $price->name,
                'description' => $price->description,
                'costInDollars' => $price->costInDollars,
                'formattedStart' => $price->formattedStart,
                'formattedEnd' => $price->formattedEnd,
                'maxInDollars' => $price->maxInDollars,
                'minInDollars' => $price->minInDollars,
                'step' => $price->step,
            ];
        }
    }

    private function preparePrices($prices)
    {
        foreach($prices as $index => $price) {
            if($this->ticketType->structure === 'flat') {
                $prices[$index]['cost'] = $price['costInDollars'] * 100;
                $prices[$index]['start'] = Carbon::parse($price['formattedStart'], $this->event->timezone)->timezone('UTC');
                $prices[$index]['end'] = Carbon::parse($price['formattedEnd'], $this->event->timezone)->timezone('UTC');
                $prices[$index]['timezone'] = $this->ticketType->timezone;
            } elseif($this->ticketType->structure === 'scaled-defined') {
                $prices[$index]['cost'] = $price['costInDollars'] * 100;
            } else {
                $prices[$index]['min'] = $price['minInDollars'] * 100;
                $prices[$index]['max'] = $price['maxInDollars'] * 100;
            }
            unset($prices[$index]['costInDollars'], $prices[$index]['minInDollars'], $prices[$index]['maxInDollars'], $prices[$index]['formattedStart'], $prices[$index]['formattedEnd']);
        }

        return collect($prices);
    }
}
