<?php

namespace Tests\Feature;

use App\Invoice;
use App\Mail\InvoiceEmail;
use App\Mail\ReceiptEmail;
use App\TicketType;
use App\User;
use App\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResendReceiptTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_resend_receipt_email()
    {
        Mail::fake();

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create([
            'email' => 'jo@example.com'
        ]);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
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
