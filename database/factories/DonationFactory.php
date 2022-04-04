<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'transaction_id' => 'trx_asdfasdfasdf',
            'amount' => 2000,
            'type' => 'one-time',
            'status' => 'successful',
        ];
    }
}
