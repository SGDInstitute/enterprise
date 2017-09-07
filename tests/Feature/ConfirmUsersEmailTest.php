<?php

namespace Tests\Feature;

use App\Mail\UserConfirmationEmail;
use App\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmUsersEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_new_user_gets_a_confirmation_email()
    {
        Mail::fake();

        $response = $this->withoutExceptionHandling()
            ->json("post", route('register'), [
                'name' => 'Phoenix Johnson',
                'email' => 'phoenix@example.com',
                'password' => 'Password1',
                'password_confirmation' => 'Password1'
            ]);

        $response->assertStatus(200);

        Mail::assertSent(UserConfirmationEmail::class, function($mail) {
            return $mail->hasTo('phoenix@example.com')
                && $mail->user->id === User::findByEmail('phoenix@example.com')->id;
        });
    }
}
