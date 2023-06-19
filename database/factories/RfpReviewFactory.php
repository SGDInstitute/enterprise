<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\Response;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RfpReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'form_id' => Form::factory(),
            'response_id' => Response::factory(),
            'alignment' => 1,
            'experience' => 1,
            'priority' => 1,
            'track' => 1,
            'score' => 4,
            'notes' => fake()->sentence(),
        ];
    }
}
