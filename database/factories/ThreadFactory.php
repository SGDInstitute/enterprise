<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'title' => 'Traveling to Conference',
            'slug' => 'traveling-to-conference',
            'content' => 'Traveling to KY from IL',
            'tags' => ['Illinois', 'Traveling'],
        ];
    }

    public function approved()
    {
        return $this->state(fn () => [
            'approved_at' => now(),
            'approved_by' => User::factory(),
        ]);
    }
}
