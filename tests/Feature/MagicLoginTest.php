<?php

namespace Tests\Feature;

use App\Mail\MagicLoginEmail;
use App\User;
use App\UserToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MagicLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_get_a_magic_login_link()
    {
        Mail::fake();

        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);

        $response = $this->withoutExceptionHandling()
            ->post('/login/magic', ['email' => 'jo@example.com']);

        $this->assertNotNull($user->token);

        Mail::assertSent(MagicLoginEmail::class, function($mail) use ($user) {
            return $mail->hasTo('jo@example.com')
                && $mail->user->id === $user->id;
        });
    }

    /** @test */
    function email_is_required()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);

        $response = $this->json("post", '/login/magic');

        $response->assertStatus(422)
            ->assertJsonHasErrors(['email']);
    }

    /** @test */
    function error_is_shown_if_user_does_not_exist()
    {
        $response = $this->post('/login/magic', ['email' => 'jo@example.com']);

        $response->assertRedirect('/login/magic')
            ->assertSessionHas('flash_notification');
    }

    /** @test */
    function clicking_on_magic_link_logs_in_user()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);
        $user->createToken();

        $response = $this->withoutExceptionHandling()
            ->get("/login/magic/{$user->token->token}?email=jo@example.com");

        $user->refresh();
        $response->assertRedirect('/home');
        $this->assertEquals($user->id, Auth::user()->id);
        $this->assertNull($user->token);
    }

    /** @test */
    function clicking_on_expired_link_shows_error()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);
        $expiredToken = $user->token()->save(factory(UserToken::class)->make(['created_at' => Carbon::now()->subMinutes(11)]));

        $response = $this->withoutExceptionHandling()
            ->get("/login/magic/{$user->token->token}?email=jo@example.com");

        $response
            ->assertRedirect('/login/magic/')
            ->assertSessionHas('flash_notification');
        $this->assertNull($user->fresh()->token);
    }

    /** @test */
    function check_that_token_belongs_to_user()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);
        $token = $user->token()->save(factory(UserToken::class)->make());
        $hacker = factory(User::class)->create([
            'email' => 'phoenix@example.com'
        ]);

        $response = $this->withoutExceptionHandling()
            ->get("/login/magic/{$user->token->token}?email=phoenix@example.com");

        $response
            ->assertRedirect('/login/magic/')
            ->assertSessionHas('flash_notification');
        $this->assertNull($user->fresh()->token);
    }
}
