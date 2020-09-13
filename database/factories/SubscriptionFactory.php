<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use App\Donation;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'donation_id' => function () {
            return Donation::factory()->create()->id;
        },
        'plan' => $this->faker->word,
        'next_charge' => $this->faker->dateTime(),
        'subscription_id' => $this->faker->word,
        'active' => $this->faker->boolean,
        'ended_at' => $this->faker->dateTime(),
    ];
    }
}
