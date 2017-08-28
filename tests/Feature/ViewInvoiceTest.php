<?php

namespace Tests\Feature;

use App\Event;
use App\Invoice;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_view_invoice()
    {
        $event = factory(Event::class)->states('published')->create([
            'stripe' => 'institute'
        ]);
        $ticketType1 = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2]
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $response = $this->withoutExceptionHandling()
            ->get("/orders/{$order->id}/invoices");

        $response->assertStatus(200)
            ->assertSee('Invoice');
    }
}
