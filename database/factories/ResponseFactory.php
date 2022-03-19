<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    public function definition()
    {
        return [
            'form_id' => 1,
            'user_id' => 1,
        ];
    }
}
