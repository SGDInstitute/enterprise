<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\UserToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => Str::random(50),
            'type' => 'magic',
        ];
    }

    public function expired()
    {
        return $this->state(function () {
            return [
                'created_at' => \Carbon\Carbon::now()->subMinutes(30),
            ];
        });
    }

    public function magic()
    {
        return $this->state(function () {
            return [
                'type' => 'magic',
            ];
        });
    }

    public function email()
    {
        return $this->state(function () {
            return [
                'type' => 'email',
            ];
        });
    }
}
