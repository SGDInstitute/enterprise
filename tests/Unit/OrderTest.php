<?php

namespace Tests\Unit;

use App\Event;
use App\Order;
use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_amount()
    {
        $event = factory(Event::class)->states('published')->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $order = $event->orderTickets(factory(User::class)->create(), [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $this->assertEquals(10000, $order->amount);
    }

    /** @test */
    public function can_mark_as_paid()
    {
        $order = factory(Order::class)->create();

        $order->markAsPaid('charge_id');

        $order->refresh();
        $this->assertEquals('charge_id', $order->transaction_id);
        $this->assertNotNull($order->transaction_date);
    }

    /** @test */
    function is_order_paid()
    {
        $order = factory(Order::class)->states('paid')->make();

        $this->assertTrue($order->isPaid());
    }

    /** @test */
    function can_mark_as_unpiad()
    {
        $order = factory(Order::class)->states('paid')->create();

        $order->markAsUnpaid();

        $order->refresh();
        $this->assertNull($order->transaction_id);
        $this->assertNull($order->transaction_date);
    }

    /** @test */
    function can_get_tickets_with_name_count_and_amount()
    {
        $event = factory(Event::class)->states('published')->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
        ]);
        $ticketType1 = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $ticketType2 = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Pro Ticket',
        ]));
        $user = factory(User::class)->create();
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType1->id, 'quantity' => 2],
            ['ticket_type_id' => $ticketType2->id, 'quantity' => 3]
        ]);

        $tickets = $order->getTicketsWithNameAndAmount();

        $this->assertEquals([
            ["name" => "Regular Ticket", "count" => 2, "amount" => 10000],
            ["name" => "Pro Ticket", "count" => 3, "amount" => 15000]
        ], $tickets->values()->all());
    }
}
