<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id' => function () {
            return User::factory()->create()->id;
        },
        'pronouns' => Arr::random(['he', 'she', 'they']),
        'sexuality' => Arr::random(['Lesbian', 'Gay', 'Straight', 'Ace']),
        'gender' => Arr::random(['Male', 'Female', 'GNC', 'Trans']),
        'race' => $this->faker->colorName,
        'college' => 'Illinois State',
        'tshirt' => Arr::random(['S', 'M', 'L', 'XL', 'XXL']),
        'accommodation' => $this->faker->paragraph(),
    ];
    }
}
