<?php

namespace Tests\Feature\Http\Controllers;

use App\Event;
use App\Mail\ReceiptEmail;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReceiptsResendController
 */
class ReceiptsResendControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_resend_receipt_email()
    {
        Mail::fake();

        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create([
            'email' => 'jo@example.com',
        ]);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $order->markAsPaid($this->charge());

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->json('get', "/receipts/{$order->receipt->id}/resend");

        $response->assertStatus(200);

        Mail::assertSent(ReceiptEmail::class, function ($mail) use ($order) {
            return $mail->hasTo('jo@example.com');
        });
    }
}
