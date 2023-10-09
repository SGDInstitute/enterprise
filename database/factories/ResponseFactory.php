<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'form_id' => Form::factory(),
            'user_id' => User::factory(),
            'type' => 'workshop',
            'answers' => ['question-name' => 'Foo Bar'],
        ];
    }

    public function withCollaborator(User $user)
    {
        return $this->afterCreating(fn ($response) => $response->collaborators()->attach($user));
    }
}
