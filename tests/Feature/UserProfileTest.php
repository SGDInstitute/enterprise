<?php

namespace Tests\Feature;

use App\Mail\UserConfirmationEmail;
use App\Profile;
use App\User;
use Illuminate\Support\Facades\Mail;
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
        $profile = $user->profile()->save(factory(Profile::class)->make([
            'pronouns' => 'he, him, his',
            'sexuality' => 'Straight',
            'gender' => 'Male',
            'race' => 'White',
            'college' => 'Hogwarts',
            'tshirt' => 'M',
            'accommodation' => 'My scar hurts sometimes.'
        ]));

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

    /** @test */
    function can_update_profile()
    {
        $user = factory(User::class)->create();
        $profile = $user->profile()->save(factory(Profile::class)->make());

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)->json("patch", "/profile", [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'M',
                'accommodation' => 'My scar hurts sometimes.'
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
        $this->assertEquals('My scar hurts sometimes.', $user->profile->accommodation);
    }

    /** @test */
    function if_email_changes_confirmation_email_is_sent()
    {
        Mail::fake();

        $user = factory(User::class)->create([
            'email' => 'hgranger@hogwarts.edu'
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)->json("patch", "/profile", [
                'name' => 'Harry Potter',
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'M',
                'accommodation' => 'My scar hurts sometimes.'
            ]);

        $response->assertStatus(200);
        Mail::assertSent(UserConfirmationEmail::class, function($mail) {
            return $mail->hasTo('hpotter@hogwarts.edu')
                && $mail->user->id === User::findByEmail('hpotter@hogwarts.edu')->id;
        });
    }

    /** @test */
    function name_is_required_to_update()
    {
        $user = factory(User::class)->create();
        $profile = $user->profile()->save(factory(Profile::class)->make());

        $response = $this->actingAs($user)->json("patch", "/profile", [
                'email' => 'hpotter@hogwarts.edu',
                'pronouns' => 'he, him, his',
                'sexuality' => 'Straight',
                'gender' => 'Male',
                'race' => 'White',
                'college' => 'Hogwarts',
                'tshirt' => 'M',
                'accommodation' => 'My scar hurts sometimes.'
            ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('name');
    }

    /** @test */
    function email_is_required_to_update()
    {
        $user = factory(User::class)->create();
        $profile = $user->profile()->save(factory(Profile::class)->make());

        $response = $this->actingAs($user)->json("patch", "/profile", [
            'name' => 'Harry Potter',
            'pronouns' => 'he, him, his',
            'sexuality' => 'Straight',
            'gender' => 'Male',
            'race' => 'White',
            'college' => 'Hogwarts',
            'tshirt' => 'M',
            'accommodation' => 'My scar hurts sometimes.'
        ]);

        $response->assertStatus(422)
            ->assertJsonHasErrors('email');
    }
}
