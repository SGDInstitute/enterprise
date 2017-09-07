<?php

namespace Tests\Unit;

use App\Mail\UserConfirmationEmail;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_change_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('Password1')
        ]);

        $user->changePassword('Password2');

        $user->fresh();
        $this->assertTrue(Hash::check('Password2', $user->password));
    }

    /** @test */
    function can_get_user_by_email()
    {
        factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);

        $foundUser = User::findByEmail('jo@example.com');

        $this->assertNotNull($foundUser);
        $this->assertEquals('jo@example.com', $foundUser->email);
    }

    /** @test */
    function can_get_email_token()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);

        $token = $user->createToken('email');

        $this->assertNotNull($user->emailToken);
        $this->assertEquals($token->token, $user->emailToken->token);
        $this->assertEquals($user->id, $token->user_id);
        $this->assertEquals($user->id, $user->emailToken->user_id);
    }

    /** @test */
    function can_get_magic_token()
    {
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);

        $token = $user->createToken('magic');

        $this->assertNotNull($user->magicToken);
        $this->assertEquals($token->token, $user->magicToken->token);
        $this->assertEquals($user->id, $token->user_id);
        $this->assertEquals($user->id, $user->magicToken->user_id);
    }

    /** @test */
    function can_see_if_user_is_confirmed()
    {
        $user = factory(User::class)->states('confirmed')->make();

        $this->assertTrue($user->isConfirmed());
    }

    /** @test */
    function can_confirm_user()
    {
        $user = factory(User::class)->create();
        $user->createToken('email');

        $user->confirm();

        $this->assertTrue($user->isConfirmed());
        $this->assertNull($user->fresh()->emailToken);
    }

    /** @test */
    function can_send_confirmation_email()
    {
        Mail::fake();

        $user = factory(User::class)->states('confirmed')->create(['email' => 'phoenix@example.com']);
        $this->assertNotNull($user->confirmed_at);

        $user->sendConfirmationEmail();

        $this->assertNull($user->confirmed_at);
        $this->assertNotNull($user->emailToken);

        Mail::assertSent(UserConfirmationEmail::class, function($mail) {
            return $mail->hasTo('phoenix@example.com')
                && $mail->user->id === User::findByEmail('phoenix@example.com')->id;
        });
    }
}
