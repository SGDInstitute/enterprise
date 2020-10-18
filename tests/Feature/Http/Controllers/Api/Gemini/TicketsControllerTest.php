<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Mail\NewTicket;
use App\Profile;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\TicketsController
 */
class TicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function post_returns_an_ok_response()
    {
        Mail::fake();
        $user = User::factory()->create(['email' => 'hpotter@hogwarts.edu']);
        Passport::actingAs($user);

        $response = $this->withoutExceptionHandling()->postJson('api/gemini/tickets', [
            'subject' => 'Testing 123',
            'message' => 'Hello does is this thing on?',
        ]);

        $response->assertOk();

        Mail::assertSent(NewTicket::class, function ($mail) use ($user) {
            return $mail->hasTo('support@sgdinstitute.org') &&
                $mail->hasCc($user->email);
        });
    }
}
