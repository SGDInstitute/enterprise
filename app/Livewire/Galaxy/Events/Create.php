<?php

namespace App\Livewire\Galaxy\Events;

use App\Livewire\Traits\WithTimezones;
use App\Models\Event;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Create extends Component
{
    use WithTimezones;

    public Event $event;

    public $formChanged = false;

    public $preset;

    public $rules = [
        'event.name' => 'required',
        'event.start' => 'required',
        'event.end' => 'required',
        'event.timezone' => 'required',
        'event.location' => '',
        'event.order_prefix' => '',
        'event.description' => 'required',
        'event.settings.reservations' => 'boolean',
        'event.settings.volunteer_discounts' => 'boolean',
        'event.settings.presenter_discounts' => 'boolean',
        'event.settings.demographics' => 'boolean',
        'event.settings.add_ons' => 'boolean',
        'event.settings.bulk' => 'boolean',
        'event.settings.invoices' => 'boolean',
        'event.settings.check_payment' => 'boolean',
        'event.settings.onsite' => 'boolean',
        'event.settings.livestream' => 'boolean',
        'event.settings.has_workshops' => 'boolean',
        'event.settings.has_volunteers' => 'boolean',
        'event.settings.has_sponsorship' => 'boolean',
        'event.settings.has_vendors' => 'boolean',
        'event.settings.has_ads' => 'boolean',
        'event.settings.allow_donations' => 'boolean',
    ];

    public function mount()
    {
        $this->event = Event::make(['name' => '', 'start' => '', 'end' => '']);
    }

    public function updating($field, $value)
    {
        if ($field === 'preset') {
            $this->event = Event::make(['name' => '', 'start' => '', 'end' => '']);
            $this->setUpPreset($value);
            $this->formChanged = true;
        }

        if (in_array($field, array_keys($this->rules))) {
            $this->formChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.create')
            ->layout('layouts.galaxy', ['title' => 'Create an Event'])
            ->with([
                'timezones' => $this->timezones,
            ]);
    }

    public function save()
    {
        $this->event->start = Carbon::parse($this->event->start->format('Y-m-d H:i'), $this->event->timezone)->timezone('UTC');
        $this->event->end = Carbon::parse($this->event->end->format('Y-m-d H:i'), $this->event->timezone)->timezone('UTC');
        $this->event->save();

        return redirect()->route('galaxy.events.edit', $this->event);
    }

    public function setUpPreset($preset)
    {
        $this->event->timezone = 'America/New_York';
        if ($preset === 'mblgtacc') {
            $this->event->name = 'MBLGTACC 20XX';
            $start = new Carbon('first Friday of October');
            $this->event->start = $start->addHours(17)->format('m/d/Y h:i A');
            $this->event->end = $start->addDays(2)->subHours(4)->format('m/d/Y h:i A');
            $this->event->order_prefix = 'MBL';
            $this->event->description = 'The Midwest Bisexual Lesbian Gay Transgender Asexual College Conference (MBLGTACC) is an annual conference held to connect, educate, and empower LGBTQIA+ college students, faculty, and staff around the Midwest and beyond. It has attracted advocates and thought leaders including Angela Davis, Robyn Ochs, Janet Mock, Laverne Cox, Kate Bornstein, Faisal Alam, and LZ Granderson; and entertainers and artists including Margaret Cho, J Mase III, Chely Wright, and Loren Cameron.';
        }
        if ($preset === 'mblgtacc' || $preset === 'conference') {
            $this->event->settings = [
                'reservations' => true,
                'volunteer_discounts' => true,
                'presenter_discounts' => true,
                'demographics' => true,
                'add_ons' => true,
                'bulk' => true,
                'invoices' => true,
                'check_payment' => true,
                'onsite' => true,
                'livestream' => false,
                'has_workshops' => true,
                'has_volunteers' => true,
                'has_sponsorship' => true,
                'has_vendors' => true,
                'has_ads' => true,
                'allow_donations' => true,
            ];
        }
        if ($preset === 'small') {
            $this->event->settings = [
                'reservations' => true,
                'volunteer_discounts' => true,
                'presenter_discounts' => true,
                'demographics' => true,
                'add_ons' => true,
                'bulk' => true,
                'invoices' => true,
                'check_payment' => true,
                'onsite' => true,
                'livestream' => true,
                'has_workshops' => false,
                'has_volunteers' => true,
                'has_sponsorship' => true,
                'has_vendors' => false,
                'has_ads' => false,
                'allow_donations' => true,
            ];
        }
        if ($preset === 'virtual') {
            $this->event->settings = [
                'reservations' => false,
                'volunteer_discounts' => false,
                'presenter_discounts' => false,
                'demographics' => true,
                'add_ons' => false,
                'bulk' => false,
                'invoices' => false,
                'check_payment' => false,
                'onsite' => false,
                'livestream' => true,
                'has_workshops' => false,
                'has_volunteers' => false,
                'has_sponsorship' => false,
                'has_vendors' => false,
                'has_ads' => false,
                'allow_donations' => true,
            ];
        }
    }
}
