<?php

namespace Tests\Feature\Api;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_authenticated_user()
    {
        $user = factory(User::class)->create([
            'name' => 'Harry Potter',
        ]);
        Passport::actingAs($user);

        $response = $this->withoutExceptionHandling()->json('get', "/api/me");

        $response->assertStatus(200);
        $this->assertEquals('Harry Potter', $response->baseResponse->getData()->data->name);
    }
}
