<?php

namespace Tests\Feature;

use App\Event;
use App\Invoice;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_invoice()
    {
        $event = factory(Event::class)->states('published')->create([
            'stripe' => 'institute',
        ]);
        $ticketType1 = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/invoices/{$invoice->id}");

        $response->assertStatus(200)
            ->assertSee('Invoice');
    }

    /** @test */
    public function can_download_invoice()
    {
        $event = factory(Event::class)->states('published')->create([
            'stripe' => 'institute',
        ]);
        $ticketType1 = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(factory(Invoice::class)->make());

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/invoices/{$invoice->id}/download");

        $response->assertStatus(200)
            ->assertHeader('content-type', 'application/pdf');
    }
}
