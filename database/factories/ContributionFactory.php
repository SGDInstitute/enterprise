<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Contribution;
use App\Event;
use App\Model;

class ContributionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contribution::class;

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
        'type' => 'sponsor',
        'title' => 'Premium Sponsor',
        'amount' => 10000,
    ];
    }
}
