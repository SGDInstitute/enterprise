<?php

namespace Database\Factories;

use App\Models\Response;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $response = Response::factory()->create();

        return [
            'invited_by' => User::factory(),
            'inviteable_id' => $response->id,
            'inviteable_type' => $response::class,
            'email' => fake()->safeEmail(),
        ];
    }
}
