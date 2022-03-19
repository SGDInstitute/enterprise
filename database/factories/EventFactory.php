<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
        if ($type === 'mblgtacc') {
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
                        'reservation_length' => 60,
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
        } elseif ($type === 'tjt') {
            return $this->state(function (array $attributes) {
                $start = new Carbon('first Thursday of November');

                return [
                    'name' => 'Transgender Justice Teach-in',
                    'start' => $start->addHours(17)->format('m/d/Y h:i A'),
                    'end' => $start->subHours(19)->format('m/d/Y h:i A'),
                    'timezone' => 'America/Chicago',
                    'order_prefix' => 'TJT',
                    'description' => 'TJT is for...',
                    'settings' => [
                        'reservations' => false,
                        'volunteer_discounts' => false,
                        'presenter_discounts' => false,
                        'demographics' => true,
                        'add_ons' => false,
                        'bulk' => true,
                        'invoices' => true,
                        'check_payment' => false,
                        'onsite' => false,
                        'livestream' => true,
                        'has_workshops' => false,
                        'has_volunteers' => false,
                        'has_sponsorship' => false,
                        'has_vendors' => false,
                        'has_ads' => false,
                        'allow_donations' => true,
                    ],
                ];
            });
        }
    }
}
