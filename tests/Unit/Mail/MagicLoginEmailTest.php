<?php

namespace Tests\Unit\Mail;

use App\Mail\MagicLoginEmail;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MagicLoginEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_has_token()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com',
        ]);
        $user->createToken('magic');
        $data = ['email' => $user->email, 'remember' => 'on'];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertStringContainsString($user->magicToken->token, $email);
    }

    /** @test */
    public function email_has_email()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com',
        ]);
        $user->createToken('magic');
        $data = ['email' => $user->email, 'remember' => 'on'];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertStringContainsString(urlencode('jo@example.com'), $email);
    }

    /** @test */
    public function email_has_remember()
    {
        $user = factory(User::class)->create();
        $user->createToken('magic');
        $data = ['email' => $user->email, 'remember' => 'on'];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertStringContainsString('remember=on', $email);
    }

    /** @test */
    public function email_doesnt_have_remember()
    {
        $user = factory(User::class)->create();
        $user->createToken('magic');
        $data = ['email' => $user->email];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertNotContains('remember=on', $email);
    }

    /** @test */
    public function url_is_correct()
    {
        $user = factory(User::class)->create();
        $user->createToken('magic');
        $data = ['email' => $user->email];

        $email = (new MagicLoginEmail($user, $data))->render();

        $this->assertStringContainsString('login/magic/', $email);
    }
}
