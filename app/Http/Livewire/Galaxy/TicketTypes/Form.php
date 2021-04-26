<?php

namespace App\Http\Livewire\Galaxy\TicketTypes;

use App\Http\Livewire\Traits\WithFormBuilder;
use App\Models\Event;
use App\Models\Price;
use App\Models\TicketType;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Form extends Component
{
    use WithFormBuilder;

    public $prices;
    public Event $event;
    public $ticketType;
    public $form;
    public $formattedStart;
    public $formattedEnd;
    public $openIndex = -1;
    public $showSettings = false;

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
            ->layout('layouts.galaxy', ['title' => $title])
            ->with([
                'fields' => $this->fields,
                'typeOptions' => $this->typeOptions,
            ]);
    }

    public function addPrice()
    {
        $this->prices[] = ['name' => '', 'costInDollars' => '0', 'formattedStart' => now($this->event->timezone)->format('m/d/Y g:i A'), 'formattedEnd' => now($this->event->timezone)->format('m/d/Y g:i A')];
    }

    public function removePrice($index)
    {
        $prices = $this->prices;
        unset($prices[$index]);
        array_values($prices);
        $this->prices = $prices;
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

        if($this->form !== []) {
            if(!is_array($this->form)) {
                $form = $this->form->toArray();
            } else {
                $form = $this->form;
            }

            foreach($form as $index => $item) {
                if($item['style'] === 'question' && $item['type'] === 'list' && is_string($item['options'])) {
                    $form[$index]['options'] = explode(",", preg_replace("/((\r?\n)|(\r\n?))/", ',', $item['options']));
                }
            }
            $this->ticketType->form = $form;
        }

        $this->ticketType->save();

        if($this->ticketType->structure === 'scaled-range' && $this->ticketType->prices->count() === 0) {
            $creating = [];

            $generating = $this->prices[0];
            $value = $generating['minInDollars'];
            while ($value <= $generating['maxInDollars']) {
                $creating[] = [
                    'name' => $generating['name'],
                    'cost' => $value * 100,
                    'start' => Carbon::parse($generating['formattedStart'], $this->ticketType->timezone ?? $this->event->timezone)->timezone('UTC'),
                    'end' => Carbon::parse($generating['formattedEnd'], $this->ticketType->timezone ?? $this->event->timezone)->timezone('UTC'),
                    'timezone' => $this->ticketType->timezone ?? $this->event->timezone,
                ];
                $value += $generating['step'];
            }

            $this->ticketType->prices()->createMany($creating);
        } else {
            [$existing, $creating] = $this->preparePrices($this->prices)->partition(function ($i) {
                return isset($i['id']);
            });

            foreach($existing as $item) {
                Price::where('id', $item['id'])->update($item);
            }
            $this->ticketType->prices()->createMany($creating);
        }

        return redirect()->route('galaxy.events.edit', ['event' => $this->event, 'page' => 'tickets']);
    }

    public function setUpCreateForm()
    {
        $this->event = Event::find(request()->get('event'));
        $this->ticketType = new TicketType(['event_id' => request()->get('event') ?? null, 'structure' => '']);
        $this->prices[] = ['name' => '', 'costInDollars' => '0', 'formattedStart' => now('America/Chicago')->format('m/d/Y g:i A'), 'formattedEnd' => now('America/Chicago')->format('m/d/Y g:i A')];
        $this->form = collect([]);
        $this->formattedStart = now('America/Chicago')->format('m/d/Y g:i A');
        $this->formattedEnd = now('America/Chicago')->format('m/d/Y g:i A');
    }

    public function setUpEditForm()
    {
        $this->ticketType = TicketType::find($this->ticketType)->load('event', 'prices');
        $this->event = $this->ticketType->event;
        $this->form = $this->ticketType->form ?? collect([]);
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
            ];
        }
    }

    private function preparePrices($prices)
    {
        foreach($prices as $index => $price) {
            $prices[$index]['cost'] = $price['costInDollars'] * 100;
            $prices[$index]['start'] = Carbon::parse($price['formattedStart'], $this->ticketType->timezone ?? $this->event->timezone)->timezone('UTC');
            $prices[$index]['end'] = Carbon::parse($price['formattedEnd'], $this->ticketType->timezone ?? $this->event->timezone)->timezone('UTC');
            $prices[$index]['timezone'] = $this->ticketType->timezone ?? $this->event->timezone;
            unset($prices[$index]['costInDollars'], $prices[$index]['formattedStart'], $prices[$index]['formattedEnd']);
        }

        return collect($prices);
    }
}
