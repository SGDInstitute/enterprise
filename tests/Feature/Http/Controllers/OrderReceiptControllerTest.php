<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderReceiptController
 */
class OrderReceiptControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_receipt()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $order->markAsPaid($this->charge());

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/orders/{$order->id}/receipt");

        $response->assertStatus(200)
            ->assertSee('receipt');
    }
}
