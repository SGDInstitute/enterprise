<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\Invoice;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InvoicesDownloadController
 */
class InvoicesDownloadControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_download_invoice()
    {
        $event = Event::factory()->published()->create([
            'stripe' => 'institute',
        ]);
        $ticketType1 = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
        ]);
        $invoice = $order->invoice()->save(Invoice::factory()->make());

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/invoices/{$invoice->id}/download");

        $response->assertStatus(200)
            ->assertHeader('content-type', 'application/pdf');
    }
}
