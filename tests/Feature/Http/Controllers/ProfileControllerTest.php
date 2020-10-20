<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProfileController
 */
class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_update_profile()
    {
        Mail::fake();
        $user = User::factory()->create();
        $profile = $user->profile()->save(Profile::factory()->make());

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)->json('patch', '/profile', [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'M',
                'accommodation' => 'My scar hurts sometimes.',
                'agreement' => true,
            ]);

        $response->assertStatus(200);
        $user->fresh();
        $this->assertEquals('Harry Potter', $user->name);
        $this->assertEquals('hpotter@hogwarts.edu', $user->email);
        $this->assertEquals('he, him, his', $user->profile->pronouns);
        $this->assertEquals('Straight', $user->profile->sexuality);
        $this->assertEquals('Male', $user->profile->gender);
        $this->assertEquals('White', $user->profile->race);
        $this->assertEquals('Hogwarts', $user->profile->college);
        $this->assertEquals('M', $user->profile->tshirt);
    }

    /** @test */
    public function if_email_changes_confirmation_email_is_sent()
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'hgranger@hogwarts.edu',
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)->json('patch', '/profile', [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'M',
                'accommodation' => 'My scar hurts sometimes.',
                'agreement' => true,
            ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function name_is_required_to_update()
    {
        $user = User::factory()->create();
        $profile = $user->profile()->save(Profile::factory()->make());

        $response = $this->actingAs($user)->json('patch', '/profile', [
            'email' => 'hpotter@hogwarts.edu',
            'pronouns' => 'he, him, his',
            'sexuality' => 'Straight',
            'gender' => 'Male',
            'race' => 'White',
            'college' => 'Hogwarts',
            'tshirt' => 'M',
            'accommodation' => 'My scar hurts sometimes.',
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('name');
    }

    /** @test */
    public function email_is_required_to_update()
    {
        $user = User::factory()->create();
        $profile = $user->profile()->save(Profile::factory()->make());

        $response = $this->actingAs($user)->json('patch', '/profile', [
            'name' => 'Harry Potter',
            'pronouns' => 'he, him, his',
            'sexuality' => 'Straight',
            'gender' => 'Male',
            'race' => 'White',
            'college' => 'Hogwarts',
            'tshirt' => 'M',
            'accommodation' => 'My scar hurts sometimes.',
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('email');
    }
}
