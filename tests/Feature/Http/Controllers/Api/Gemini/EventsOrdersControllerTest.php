<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Models\Event;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventsOrdersController
 */
class EventsOrdersControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $orderOwner = User::factory()->create(['email' => 'jo@example.com']);
        $attendee = User::factory()->create(['email' => 'john@example.com']);
        $order = Order::factory()->create(['event_id' => $event->id, 'user_id' => $orderOwner->id]);
        $ticket1 = Ticket::factory()->create([
            'order_id' => $order->id,
            'user_id' => $orderOwner->id,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket2 = Ticket::factory()->create([
            'order_id' => $order->id,
            'user_id' => $attendee->id,
            'ticket_type_id' => $ticketType->id,
        ]);

        Passport::actingAs($attendee);

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/orders");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'owner_id',
                    'is_paid',
                    'confirmation_number',
                    'amount',
                    'tickets',
                ],
            ],
        ]);

        $this->assertCount(1, $response->decodeResponseJson()['data']);
        $this->assertCount(2, $response->decodeResponseJson()['data'][0]['tickets']);
        $this->assertLessThanOrEqual(10, count(DB::getQueryLog()));
    }

    /** @test */
    public function user_that_is_in_order_returns_the_order()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create(['email' => 'jo@example.com']);
        $order = Order::factory()->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = Ticket::factory()->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket2 = Ticket::factory()->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);

        Passport::actingAs($user);

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/orders");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'owner_id',
                    'is_paid',
                    'confirmation_number',
                    'amount',
                    'tickets',
                ],
            ],
        ]);

        $this->assertCount(1, $response->decodeResponseJson()['data']);
        $this->assertCount(2, $response->decodeResponseJson()['data'][0]['tickets']);
        $this->assertLessThanOrEqual(10, count(DB::getQueryLog()));
    }

    /** @test */
    public function tickets_that_are_in_queue_are_true()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create(['email' => 'jo@example.com']);
        $order = Order::factory()->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = Ticket::factory()->create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'ticket_type_id' => $ticketType->id,
        ]);
        Queue::create([
            'batch' => Hashids::encode($order->id),
            'ticket_id' => $ticket1->id,
            'name' => $user->name,
            'pronouns' => $user->profile->pronouns,
            'college' => $user->profile->college,
            'tshirt' => $user->profile->tshirt,
            'order_created' => $order->created_at,
            'order_paid' => optional($order->receipt)->created_at,
        ]);
        $ticket2 = Ticket::factory()->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);

        Passport::actingAs($user);

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/orders");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'owner_id',
                    'is_paid',
                    'confirmation_number',
                    'amount',
                    'tickets',
                ],
            ],
        ]);

        $this->assertCount(1, $response->decodeResponseJson()['data']);
        $this->assertCount(2, $response->decodeResponseJson()['data'][0]['tickets']);
        $this->assertTrue($response->decodeResponseJson()['data'][0]['tickets'][0]['in_queue']);
        $this->assertFalse($response->decodeResponseJson()['data'][0]['tickets'][0]['is_printed']);
        $this->assertFalse($response->decodeResponseJson()['data'][0]['tickets'][1]['in_queue']);
        $this->assertFalse($response->decodeResponseJson()['data'][0]['tickets'][1]['is_printed']);
        $this->assertLessThanOrEqual(10, count(DB::getQueryLog()));
    }

    /** @test */
    public function tickets_that_are_printed_are_true()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make());
        $user = User::factory()->create(['email' => 'jo@example.com']);
        $order = Order::factory()->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = Ticket::factory()->create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'ticket_type_id' => $ticketType->id,
        ]);
        $queue = Queue::create([
            'batch' => Hashids::encode($order->id),
            'ticket_id' => $ticket1->id,
            'name' => $user->name,
            'pronouns' => $user->profile->pronouns,
            'college' => $user->profile->college,
            'tshirt' => $user->profile->tshirt,
            'order_created' => $order->created_at,
            'order_paid' => optional($order->receipt)->created_at,
        ]);
        Queue::complete($queue);
        $ticket2 = Ticket::factory()->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);

        Passport::actingAs($user);

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/orders");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'owner_id',
                    'is_paid',
                    'confirmation_number',
                    'amount',
                    'tickets',
                ],
            ],
        ]);

        $this->assertCount(1, $response->decodeResponseJson()['data']);
        $this->assertCount(2, $response->decodeResponseJson()['data'][0]['tickets']);
        $this->assertTrue($response->decodeResponseJson()['data'][0]['tickets'][0]['in_queue']);
        $this->assertTrue($response->decodeResponseJson()['data'][0]['tickets'][0]['is_printed']);
        $this->assertFalse($response->decodeResponseJson()['data'][0]['tickets'][1]['in_queue']);
        $this->assertFalse($response->decodeResponseJson()['data'][0]['tickets'][1]['is_printed']);
        $this->assertLessThanOrEqual(10, count(DB::getQueryLog()));
    }
}
