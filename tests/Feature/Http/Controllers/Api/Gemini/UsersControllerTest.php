<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
        $user = User::factory()->create([
            'name' => 'Ginny Weasley',
            'email' => 'gweasley@hogwarts.edu',
        ]);
        $user->profile->update([
            'pronouns' => 'she/her',
            'sexuality' => 'bisexual',
            'gender' => 'female',
            'race' => 'white',
            'college' => 'Hogwarts',
            'tshirt' => 'M',
            'other_language' => 'GB English',
        ]);

        Passport::actingAs($user);

        $response = $this->withoutExceptionHandling()->getJson('api/gemini/me');

        $this->assertEquals('Ginny Weasley', $response->decodeResponseJson()['data']['name']);
        $this->assertEquals('gweasley@hogwarts.edu', $response->decodeResponseJson()['data']['email']);
        $this->assertEquals('she/her', $response->decodeResponseJson()['data']['pronouns']);
        $this->assertEquals('bisexual', $response->decodeResponseJson()['data']['sexuality']);
        $this->assertEquals('female', $response->decodeResponseJson()['data']['gender']);
        $this->assertEquals('white', $response->decodeResponseJson()['data']['race']);
        $this->assertEquals('Hogwarts', $response->decodeResponseJson()['data']['college']);
        $this->assertEquals('M', $response->decodeResponseJson()['data']['tshirt']);
        $this->assertEquals(['GB English'], $response->decodeResponseJson()['data']['language']);
    }

    /** @test */
    public function update_returns_an_ok_response()
    {
        $user = User::factory()->create([
            'name' => 'Ginny Weasley',
            'email' => 'gweasley@hogwarts.edu',
        ]);
        $user->profile->update([
            'pronouns' => 'she/her',
            'sexuality' => 'bisexual',
            'gender' => 'female',
            'race' => 'white',
            'college' => 'Hogwarts',
            'tshirt' => 'M',
            'other_language' => 'GB English',
        ]);

        Passport::actingAs($user);

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->json('patch', 'api/gemini/me', [
            'name' => 'Ginny Weasley',
            'email' => 'gweasley@hogwarts.edu',
            'pronouns' => 'she/her',
            'sexuality' => 'queer',
            'gender' => 'whatever',
            'race' => 'white',
            'college' => 'Hogwarts',
            'tshirt' => 'S',
        ]);

        $this->assertEquals('Ginny Weasley', $response->decodeResponseJson()['data']['name']);
        $this->assertEquals('gweasley@hogwarts.edu', $response->decodeResponseJson()['data']['email']);
        $this->assertEquals('she/her', $response->decodeResponseJson()['data']['pronouns']);
        $this->assertEquals('queer', $response->decodeResponseJson()['data']['sexuality']);
        $this->assertEquals('whatever', $response->decodeResponseJson()['data']['gender']);
        $this->assertEquals('white', $response->decodeResponseJson()['data']['race']);
        $this->assertEquals('Hogwarts', $response->decodeResponseJson()['data']['college']);
        $this->assertEquals('S', $response->decodeResponseJson()['data']['tshirt']);
        $this->assertLessThan(5, count(DB::getQueryLog()));
    }
}
