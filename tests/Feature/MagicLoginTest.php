<?php

namespace Tests\Feature;

use App\Mail\MagicLoginEmail;
use App\User;
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
}
