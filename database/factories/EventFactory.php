<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'name' => '',
        ];
    }

    public function preset($type)
    {
        if($type === 'mblgtacc') {
            return $this->state(function (array $attributes) {
                $start = new Carbon('first Friday of October');
                return [
                    'name' => 'MBLGTACC 20XX',
                    'start' => $start->addHours(17)->format('m/d/Y h:i A'),
                    'end' => $start->addDays(2)->subHours(4)->format('m/d/Y h:i A'),
                    'timezone' => 'America/New_York',
                    'order_prefix' => 'MBL',
                    'description' => 'MBGLTACC is the longest running blah blah blah',
                    'settings' => [
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
                    ],
                ];
            });
        }
    }
}
