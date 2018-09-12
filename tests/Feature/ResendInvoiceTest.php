<?php

namespace Tests\Feature;

use App\Invoice;
use App\Mail\InvoiceEmail;
use App\TicketType;
use App\User;
use App\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResendInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_resend_invoice_email()
    {
        Mail::fake();

        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $invoice = $order->invoice()->save(factory(Invoice::class)->make(['email' => 'pjohnson@example.com']));

        $response = $this->withoutExceptionHandling()->actingAs($user)->json('get', "/invoices/{$invoice->id}/resend");

        $response->assertStatus(200);

        Mail::assertSent(InvoiceEmail::class, function ($mail) use ($invoice) {
            return $mail->hasTo('jo@example.com')
                && $mail->hasCc('pjohnson@example.com');
        });
    }
}
