<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_authenticated_user()
    {
        $user = factory(User::class)->create([
            'name' => 'Harry Potter',
        ]);
        Passport::actingAs($user);

        $response = $this->withoutExceptionHandling()->json('get', '/api/me');

        $response->assertStatus(200);
        $this->assertEquals('Harry Potter', $response->baseResponse->getData()->data->name);
    }
}
