<?php

namespace Database\Factories;

use App\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\TicketType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'event_id' => function () {
            return Event::factory()->create()->id;
        },
        'name' => 'Regular Ticket',
        'description' => 'Regular admission to the event.',
        'cost' => 1500,
        'availability_start' => \Carbon\Carbon::now()->subMonth(),
        'availability_end' => \Carbon\Carbon::now()->addMonth(3),
    ];
    }
}
