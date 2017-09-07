<?php

namespace Tests\Unit\Mail;

use App\Mail\MagicLoginEmail;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MagicLoginEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function email_has_token()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);
        $user->createToken();
        $data = ['email' => $user->email, 'remember' => 'on'];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertContains($user->token->token, $email);
    }

    /** @test */
    function email_has_email()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);
        $user->createToken();
        $data = ['email' => $user->email, 'remember' => 'on'];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertContains(urlencode('jo@example.com'), $email);
    }

    /** @test */
    function email_has_remember()
    {
        $user = factory(User::class)->create();
        $user->createToken();
        $data = ['email' => $user->email, 'remember' => 'on'];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertContains('remember=on', $email);
    }

    /** @test */
    function email_doesnt_have_remember()
    {
        $user = factory(User::class)->create();
        $user->createToken();
        $data = ['email' => $user->email];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertNotContains('remember=on', $email);
    }
}
