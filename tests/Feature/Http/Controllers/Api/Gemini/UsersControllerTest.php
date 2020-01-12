<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\UsersController
 */
class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_returns_an_ok_response()
    {
        $user = factory(User::class)->create([
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
        ]);
        $profile = factory(Profile::class)->create([
            'user_id' => $user->id,
            'pronouns' => 'he/him',
        ]);

        Passport::actingAs($user);

        $response = $this->withoutExceptionHandling()->getJson("api/gemini/me");

        $this->assertEquals('Harry Potter', $response->decodeResponseJson()['data']['name']);
        $this->assertEquals('hpotter@hogwarts.edu', $response->decodeResponseJson()['data']['email']);
        $this->assertEquals('he/him', $response->decodeResponseJson()['data']['pronouns']);
    }
}
