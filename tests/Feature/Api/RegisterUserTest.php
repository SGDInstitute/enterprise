<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_register_user()
    {
        $response = $this->withoutExceptionHandling()->json('post', '/api/users', [
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
            'password' => 'Password1',
            'password_confirmation' => 'Password1',
        ]);

        $response->assertStatus(200);
        $this->assertTrue(User::where('email', 'hpotter@hogwarts.edu')->exists());
    }
}
