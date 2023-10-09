<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory()->preset('mblgtacc'),
            'user_id' => User::factory(),
            'reservation_ends' => now()->addDays(15),
            'status' => 'reservation',
        ];
    }

    public function paid(string $transactionType = 'check')
    {
        $transactionId = match ($transactionType) {
            'check' => '#1234',
            'card' => 'pi_test_1234',
            'comped' => 'comped',
        };

        return $this->state(function (array $attributes) use ($transactionId) {
            return [
                'confirmation_number' => 'CONFIRMATIONNUMBER',
                'transaction_id' => $transactionId,
                'status' => 'succeeded',
                'amount' => 8500,
                'reservation_ends' => null,
                'paid_at' => now(),
            ];
        });
    }
}
