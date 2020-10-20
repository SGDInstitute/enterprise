<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class QueueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Queue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'batch' => 'ABCDE',
            'ticket_id' => Ticket::factory()->create(),
            'name' => $this->faker->name,
            'pronouns' => 'they/them',
            'college' => 'Hogwarts Edu.',
            'tshirt' => 'S',
            'order_created' => '2019-01-15 00:00:00',
            'order_paid' => '2019-01-15 00:00:00',
        ];
    }
}
