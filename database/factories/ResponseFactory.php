<?php

namespace Database\Factories;

use App\Models\Response;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    protected $model = Response::class;

    public function definition()
    {
        return [
            'form_id' => 1,
            'user_id' => 1,
        ];
    }
}
