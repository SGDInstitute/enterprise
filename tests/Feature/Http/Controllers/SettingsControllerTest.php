<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SettingsController
 */
class SettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function view_user_profile()
    {
        $user = User::factory()->create([
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
        ]);
        $profile = $user->profile()->update([
            'pronouns' => 'he, him, his',
            'sexuality' => 'Straight',
            'gender' => 'Male',
            'race' => 'White',
            'college' => 'Hogwarts',
            'tshirt' => 'M',
            'accommodation' => 'My scar hurts sometimes.',
        ]);

        $response = $this->withExceptionHandling()->actingAs($user)->get('/settings');

        $response->assertStatus(200);
        $response->assertSee('Harry Potter');
        $response->assertSee('hpotter@hogwarts.edu');
        $response->assertSee('he, him, his');
        $response->assertSee('Straight');
        $response->assertSee('Male');
        $response->assertSee('White');
        $response->assertSee('Hogwarts');
        $response->assertSee('M');
        $response->assertSee('My scar hurts sometimes.');
    }

    /** @test */
    public function view_user_profile_for_new_user()
    {
        $user = User::factory()->create([
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
        ]);

        $response = $this->withExceptionHandling()->actingAs($user)->get('/settings');

        $response->assertStatus(200);
        $response->assertSee('Harry Potter');
        $response->assertSee('hpotter@hogwarts.edu');
    }
}
