<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'In-person',
            'cost' => 1000,
        ];
    }
}
