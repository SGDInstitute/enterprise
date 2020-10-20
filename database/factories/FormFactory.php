<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Form::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => 'Test Survey',
            'slug'      => 'test-survey',
            'start'     => $this->faker->date(),
            'end'       => $this->faker->date(),
            'is_public' => true,
            'form'      => '[
                    {
                    "id": 1,
                    "question": "Hello world.",
                    "type": "textarea",
                    "required": false,
                    }
                ]',
        ];
    }
}
