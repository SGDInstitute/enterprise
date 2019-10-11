<?php

namespace Tests\Feature\Api;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_register_user()
    {
        $response = $this->withoutExceptionHandling()->json('post', "/api/users", [
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ]);

        $response->assertStatus(201);
        $this->assertTrue(User::where('email', 'hpotter@hogwarts.edu')->exists());
    }
}
