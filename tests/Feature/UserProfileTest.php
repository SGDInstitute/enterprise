<?php

namespace Tests\Feature;

use App\Profile;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function view_user_profile()
    {
        $user = factory(User::class)->create([
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
        ]);
        $profile = factory(Profile::class)->make([
            'pronouns' => 'he, him, his',
            'sexuality' => 'Straight',
            'gender' => 'Male',
            'race' => 'White',
            'college' => 'Hogwarts',
            'tshirt' => 'M',
            'accommodation' => 'My scar hurts sometimes.'
        ]);
        $user->profile()->save($profile);

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
    function view_user_profile_for_new_user()
    {
        $user = factory(User::class)->create([
            'name' => 'Harry Potter',
            'email' => 'hpotter@hogwarts.edu',
        ]);

        $response = $this->withExceptionHandling()->actingAs($user)->get('/settings');

        $response->assertStatus(200);
        $response->assertSee('Harry Potter');
        $response->assertSee('hpotter@hogwarts.edu');
    }
}
