<?php

namespace Tests\Unit;

use App\Event;
use App\Order;
use App\Ticket;
use App\TicketType;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_amount_for_unpaid_order()
    {
        $event = Event::factory()->published()->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $order = $event->orderTickets(User::factory()->create(), [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $this->assertEquals(10000, $order->amount);
    }

    /** @test */
    public function can_get_amount_for_paid_order()
    {
        $event = Event::factory()->published()->create();
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $order = $event->orderTickets(User::factory()->create(), [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 1],
        ]);

        $order->markAsPaid($this->charge());
        $ticketType->cost = 7500;
        $ticketType->save();

        $this->assertEquals(5000, $order->amount);
    }

    /** @test */
    public function can_mark_as_paid()
    {
        $order = Order::factory()->create();

        $order->markAsPaid($this->charge());

        $order->refresh();
        $this->assertEquals('charge_id', $order->receipt->transaction_id);
        $this->assertNotNull($order->receipt->created_at);
        $this->assertEquals(5000, $order->receipt->amount);
        $this->assertNotNull($order->confirmation_number);
    }

    /** @test */
    public function is_order_paid()
    {
        $order = Order::factory()->create();
        $order->markAsPaid($this->charge());

        $this->assertTrue($order->isPaid());
        $this->assertNotNull($order->receipt);
    }

    /** @test */
    public function can_mark_as_unpiad()
    {
        $order = Order::factory()->create();
        $order->markAsPaid($this->charge());

        $order->markAsUnpaid();

        $order->refresh();

        $this->assertNull($order->receipt);
        $this->assertNull($order->confirmation_number);
    }

    /** @test */
    public function can_get_tickets_with_name_count_and_amount()
    {
        $event = Event::factory()->published()->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType1 = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $ticketType2 = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 6000,
            'name' => 'Pro Ticket',
        ]));
        $user = User::factory()->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
            ['ticket_type_id' => $ticketType2->id, 'quantity' => 3],
        ]);

        $tickets = $order->getTicketsWithNameAndAmount();

        $this->assertEquals([
            ['name' => 'Regular Ticket', 'count' => 2, 'cost' => 5000, 'amount' => 10000],
            ['name' => 'Pro Ticket', 'count' => 3, 'cost' => 6000, 'amount' => 18000],
        ], $tickets->values()->all());
    }

    /** @test */
    public function can_get_orders_with_upcoming_events()
    {
        $user = User::factory()->create();
        $upcomingEvent = Event::factory()->published()->create([
            'start' => Carbon::now()->addMonth(2),
        ]);
        $ticketType = $upcomingEvent->ticket_types()->save(TicketType::factory()->make());
        $order1 = $upcomingEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $order2 = $upcomingEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $order3 = $upcomingEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $pastEvent = Event::factory()->published()->create([
            'end' => Carbon::now()->subMonth(2),
        ]);
        $ticketType = $pastEvent->ticket_types()->save(TicketType::factory()->make());
        $order = $pastEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $upcoming = $user->orders()->upcoming()->get()->pluck('id');

        $this->assertCount(3, $upcoming);
        $this->assertStringContainsString($order1->id, $upcoming);
        $this->assertStringContainsString($order2->id, $upcoming);
        $this->assertStringContainsString($order3->id, $upcoming);
    }

    /** @test */
    public function can_get_orders_with_past_events()
    {
        $user = User::factory()->create();
        $upcomingEvent = Event::factory()->published()->create([
            'start' => Carbon::now()->addMonth(2),
        ]);
        $ticketType = $upcomingEvent->ticket_types()->save(TicketType::factory()->make());
        $order = $upcomingEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $pastEvent = Event::factory()->published()->create([
            'end' => Carbon::now()->subMonth(2),
        ]);
        $ticketType = $pastEvent->ticket_types()->save(TicketType::factory()->make());
        $order1 = $pastEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $order2 = $pastEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);
        $order3 = $pastEvent->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $past = $user->orders()->past()->get()->pluck('id');

        $this->assertCount(3, $past);
        $this->assertStringContainsString($order1->id, $past);
        $this->assertStringContainsString($order2->id, $past);
        $this->assertStringContainsString($order3->id, $past);
    }

    /** @test */
    public function can_see_if_order_was_paid_with_check()
    {
        $order = Order::factory()->create();
        $order->markAsPaid(collect(['id' => '#1234', 'amount' => $order->amount]));

        $this->assertTrue($order->refresh()->isCheck());
    }

    /** @test */
    public function can_see_if_order_was_paid_with_card()
    {
        $order = Order::factory()->create();
        $order->markAsPaid($this->charge());

        $this->assertTrue($order->refresh()->isCard());
    }

    /** @test */
    public function tickets_are_deleted_when_order_is()
    {
        $event = Event::factory()->published()->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(TicketType::factory()->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $order = $event->orderTickets(User::factory()->create(), [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2],
        ]);

        $order->delete();

        $this->assertEmpty(Ticket::all());
    }

    /** @test */
    public function can_get_paid_orders()
    {
        $paidOrder1 = Order::factory()->paid()->create();
        $paidOrder2 = Order::factory()->paid()->create();
        $unpaidOrder1 = Order::factory()->create();
        $unpaidOrder2 = Order::factory()->create();

        $this->assertCount(2, Order::paid()->get());
    }
}
