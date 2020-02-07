<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Event;
use App\Order;
use App\Queue;
use App\Ticket;
use App\TicketType;
use App\User;
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
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $orderOwner = factory(User::class)->create(['email' => 'jo@example.com']);
        $attendee = factory(User::class)->create(['email' => 'john@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $orderOwner->id]);
        $ticket1 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => $orderOwner->id,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket2 = factory(Ticket::class)->create([
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
                    'tickets'
                ]
            ]
        ]);

        $this->assertCount(1, $response->decodeResponseJson()['data']);
        $this->assertCount(2, $response->decodeResponseJson()['data'][0]['tickets']);
        $this->assertLessThanOrEqual(10, count(DB::getQueryLog()));
    }

    /** @test */
    public function user_that_is_in_order_returns_the_order()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = factory(Ticket::class)->create([
            'order_id' => $order->id,
            'user_id' => null,
            'ticket_type_id' => $ticketType->id,
        ]);
        $ticket2 = factory(Ticket::class)->create([
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
                    'tickets'
                ]
            ]
        ]);

        $this->assertCount(1, $response->decodeResponseJson()['data']);
        $this->assertCount(2, $response->decodeResponseJson()['data'][0]['tickets']);
        $this->assertLessThanOrEqual(10, count(DB::getQueryLog()));
    }

    /** @test */
    public function tickets_that_are_in_queue_are_true()
    {
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = factory(Ticket::class)->create([
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
        $ticket2 = factory(Ticket::class)->create([
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
                    'tickets'
                ]
            ]
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
        $event = factory(Event::class)->states('published')->create();
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make());
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $order = factory(Order::class)->create(['event_id' => $event->id, 'user_id' => $user->id]);
        $ticket1 = factory(Ticket::class)->create([
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
        $ticket2 = factory(Ticket::class)->create([
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
                    'tickets'
                ]
            ]
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
