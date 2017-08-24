<?php

namespace Tests\Unit;

use App\TicketType;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Event;
use Carbon\Carbon;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function events_with_a_published_at_date_in_the_past_are_published()
    {
        $publishedEventA = factory(Event::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $publishedEventB = factory(Event::class)->create(['published_at' => Carbon::now()]);
        $unpublishedEventA = factory(Event::class)->create(['published_at' => NULL]);
        $unpublishedEventB = factory(Event::class)->create(['published_at' => Carbon::parse('+1 week')]);

        $publishedEvents = Event::published()->get();

        $this->assertTrue($publishedEvents->contains($publishedEventA));
        $this->assertTrue($publishedEvents->contains($publishedEventB));
        $this->assertFalse($publishedEvents->contains($unpublishedEventA));
        $this->assertFalse($publishedEvents->contains($unpublishedEventB));
    }

    /** @test */
    function can_find_event_by_slug()
    {
        factory(Event::class)->create(['slug' => 'hello-world']);

        $event = Event::findBySlug('hello-world');

        $this->assertNotNull($event);
    }

    /** @test */
    function can_order_concert_tickets()
    {
        $event = factory(Event::class)->create();
        $user = factory(User::class)->create();
        $ticket_type = factory(TicketType::class)->make([
            'name' => 'Regular Ticket',
            'cost' => 5000,
        ]);
        $ticket_type2 = factory(TicketType::class)->make([
            'name' => 'Late Ticket',
            'cost' => 10000,
        ]);
        $event->ticket_types()->save($ticket_type);
        $event->ticket_types()->save($ticket_type2);

        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticket_type->id, 'quantity' => 4],
            ['ticket_type_id' => $ticket_type2->id, 'quantity' => 1],
        ]);

        $this->assertEquals($user->id, $order->user->id);
        $this->assertEquals(5, $order->tickets()->count());
        $this->assertEquals(4, $order->tickets()->where('ticket_type_id', $ticket_type->id)->count());
        $this->assertEquals(1, $order->tickets()->where('ticket_type_id', $ticket_type2->id)->count());
    }

    /** @test */
    function can_order_concert_tickets_without_getting_multiple_ticket_types()
    {
        $event = factory(Event::class)->create();
        $user = factory(User::class)->create();
        $ticket_type = factory(TicketType::class)->make([
            'name' => 'Regular Ticket',
            'cost' => 5000,
        ]);
        $ticket_type2 = factory(TicketType::class)->make([
            'name' => 'Late Ticket',
            'cost' => 10000,
        ]);
        $event->ticket_types()->save($ticket_type);
        $event->ticket_types()->save($ticket_type2);

        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticket_type->id, 'quantity' => 2],
            ['ticket_type_id' => $ticket_type2->id, 'quantity' => 0],
        ]);

        $this->assertEquals($user->id, $order->user->id);
        $this->assertEquals(2, $order->tickets()->count());
        $this->assertEquals(2, $order->tickets()->where('ticket_type_id', $ticket_type->id)->count());
        $this->assertEquals(0, $order->tickets()->where('ticket_type_id', $ticket_type2->id)->count());
    }
    
    /** @test */
    function can_get_stripe_keys_from_event()
    {
        $mblgtaccEvent = factory(Event::class)->create(['stripe' => 'mblgtacc']);
        $instituteEvent = factory(Event::class)->create(['stripe' => 'institute']);

        $this->assertNotNull($mblgtaccEvent->getPublicKey());
        $this->assertNotNull($mblgtaccEvent->getSecretKey());
        $this->assertNotNull($instituteEvent->getPublicKey());
        $this->assertNotNull($instituteEvent->getSecretKey());
    }

    /** @test */
    function can_view_formatted_start()
    {
        $event = factory(Event::class)->make([
            'start' => Carbon::parse('august 11 2017 5:50 PM'),
            'timezone' => 'America/Chicago',
        ]);

        $this->assertEquals('Fri, Aug 11', $event->formatted_start);
    }

    /** @test */
    function can_view_formatted_end()
    {
        $event = factory(Event::class)->make([
            'end' => Carbon::parse('august 11 2017 5:50 PM'),
            'timezone' => 'America/Chicago',
        ]);

        $this->assertEquals('Fri, Aug 11', $event->formatted_end);
    }

    /** @test */
    function can_view_duration()
    {
        $event = factory(Event::class)->make([
            'start' => Carbon::parse('august 11 2017 5:00 PM', 'America/Chicago')->timezone('UTC'),
            'end' => Carbon::parse('august 13 2017 5:00 PM', 'America/Chicago')->timezone('UTC'),
            'timezone' => 'America/Chicago',
        ]);

        $this->assertEquals('Friday August 11, 2017 5:00 PM to Sunday August 13, 2017 5:00 PM CDT',
            $event->duration);
    }
}
