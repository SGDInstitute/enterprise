<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\UsersPushController
 */
class UsersPushControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function store_returns_an_ok_response()
    {
        $user = factory(User::class)->create([
            'name' => 'Ginny Weasley',
            'email' => 'gweasley@hogwarts.edu',
        ]);

        Passport::actingAs($user);

        $response = $this->withoutExceptionHandling()->postJson("api/gemini/me/push", [
            'token' => 'EXAMPLE-PUSH-TOKEN',
        ]);

        $this->assertEquals('EXAMPLE-PUSH-TOKEN', $response->decodeResponseJson()['data']['push_token']);
    }
}
