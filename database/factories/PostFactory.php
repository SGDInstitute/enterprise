<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'title' => 'Traveling to Conference',
            'content' => 'Traveling to KY from IL',
            // 'tags' => ['Illinois', 'Traveling'],
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
