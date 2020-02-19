<?php

namespace Tests\Unit\Mail;

use App\Mail\UserConfirmationEmail;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserConfirmationEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_has_token()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com',
        ]);
        $token = $user->createToken('email');

        $email = (new UserConfirmationEmail($user))->render();

        $this->assertContains($token->token, $email);
    }

    /** @test */
    public function email_has_email()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com',
        ]);
        $user->createToken('email');

        $email = (new UserConfirmationEmail($user))->render();

        $this->assertContains(urlencode('jo@example.com'), $email);
    }

    /** @test */
    public function url_is_correct()
    {
        $user = factory(User::class)->create();
        $user->createToken('email');

        $email = (new UserConfirmationEmail($user))->render();

        $this->assertContains('/register/verify/', $email);
    }
}
