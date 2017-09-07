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
        $user = factory(User::class)->create();
        $user->createToken();

        $email = (new MagicLoginEmail($user))->render();

        $this->assertContains(url('/login/magiclink/' . $user->token->token), $email);
    }
}
