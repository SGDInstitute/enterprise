<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\Invoice;
use App\Mail\InvoiceEmail;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InvoicesResendController
 */
class InvoicesResendControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_resend_invoice_email()
    {
        Mail::fake();

        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create(['email' => 'jo@example.com']);
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $invoice = $order->invoice()->save(Invoice::factory()->make(['email' => 'pjohnson@example.com']));

        $response = $this->withoutExceptionHandling()->actingAs($user)->json('get', "/invoices/{$invoice->id}/resend");

        $response->assertStatus(200);

        Mail::assertSent(InvoiceEmail::class, function ($mail) use ($invoice) {
            return $mail->hasTo('jo@example.com')
                && $mail->hasCc('pjohnson@example.com');
        });
    }
}
