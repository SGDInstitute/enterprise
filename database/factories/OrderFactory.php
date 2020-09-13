<?php

namespace Database\Factories;

use App\Event;
use App\Order;
use App\Receipt;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

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
        'user_id' => function () {
            return User::factory()->create()->id;
        },
    ];
    }

    public function paid()
    {
        return $this->state(function () {
            return [
        'confirmation_number' => Facades\App\ConfirmationNumber::generate(),
    ];
        });
    }

    public function check()
    {
        return $this->state(function () {
            return [
        'transaction_id' => '#1234',
    ];
        });
    }
}
