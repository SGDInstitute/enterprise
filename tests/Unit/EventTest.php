<?php

namespace Tests\Unit;

use App\Event;
use App\TicketType;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function events_with_a_published_at_date_in_the_past_are_published()
    {
        $publishedEventA = Event::factory()->create(['published_at' => Carbon::parse('-1 week')]);
        $publishedEventB = Event::factory()->create(['published_at' => Carbon::now()]);
        $unpublishedEventA = Event::factory()->create(['published_at' => null]);
        $unpublishedEventB = Event::factory()->create(['published_at' => Carbon::parse('+1 week')]);

        $publishedEvents = Event::published()->get();

        $this->assertTrue($publishedEvents->contains($publishedEventA));
        $this->assertTrue($publishedEvents->contains($publishedEventB));
        $this->assertFalse($publishedEvents->contains($unpublishedEventA));
        $this->assertFalse($publishedEvents->contains($unpublishedEventB));
    }

    /** @test */
    public function can_find_event_by_slug()
    {
        Event::factory()->create(['slug' => 'hello-world']);

        $event = Event::findBySlug('hello-world');

        $this->assertNotNull($event);
    }

    /** @test */
    public function can_order_concert_tickets()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $ticket_type = TicketType::factory()->make([
            'name' => 'Regular Ticket',
            'cost' => 5000,
        ]);
        $ticket_type2 = TicketType::factory()->make([
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
    public function can_order_concert_tickets_without_getting_multiple_ticket_types()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();
        $ticket_type = TicketType::factory()->make([
            'name' => 'Regular Ticket',
            'cost' => 5000,
        ]);
        $ticket_type2 = TicketType::factory()->make([
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
    public function can_get_stripe_keys_from_event()
    {
        $mblgtaccEvent = Event::factory()->create(['stripe' => 'mblgtacc']);
        $instituteEvent = Event::factory()->create(['stripe' => 'institute']);

        $this->assertNotNull($mblgtaccEvent->getPublicKey());
        $this->assertNotNull($mblgtaccEvent->getSecretKey());
        $this->assertNotNull($instituteEvent->getPublicKey());
        $this->assertNotNull($instituteEvent->getSecretKey());
    }

    /** @test */
    public function can_view_formatted_start()
    {
        $event = Event::factory()->make([
            'start' => Carbon::parse('august 11 2017 5:50 PM'),
            'timezone' => 'America/Chicago',
        ]);

        $this->assertEquals('Fri, Aug 11', $event->formatted_start);
    }

    /** @test */
    public function can_view_formatted_end()
    {
        $event = Event::factory()->make([
            'end' => Carbon::parse('august 11 2017 5:50 PM'),
            'timezone' => 'America/Chicago',
        ]);

        $this->assertEquals('Fri, Aug 11', $event->formatted_end);
    }

    /** @test */
    public function can_view_duration()
    {
        $event = Event::factory()->make([
            'start' => Carbon::parse('august 11 2017 5:00 PM', 'America/Chicago')->timezone('UTC'),
            'end' => Carbon::parse('august 13 2017 5:00 PM', 'America/Chicago')->timezone('UTC'),
            'timezone' => 'America/Chicago',
        ]);

        $this->assertEquals(
            'Friday August 11, 2017 5:00 PM to Sunday August 13, 2017 5:00 PM CDT',
            $event->duration
        );
    }

    /** @test */
    public function can_upcoming_events()
    {
        $upcomingEvent1 = Event::factory()->published()->create([
            'start' => Carbon::now()->addMonth(2),
        ]);
        $upcomingEvent2 = Event::factory()->published()->create([
            'start' => Carbon::now()->addMonth(5),
        ]);
        $pastEvent = Event::factory()->published()->create([
            'start' => Carbon::now()->subMonth(2),
        ]);
        $unpublishedEvent = Event::factory()->unpublished()->create([
            'start' => Carbon::now()->addYear(),
        ]);

        $upcoming = Event::upcoming()->get();

        $this->assertCount(3, $upcoming);
        $this->assertTrue($upcoming->contains($upcomingEvent1));
        $this->assertTrue($upcoming->contains($upcomingEvent2));
        $this->assertFalse($upcoming->contains($pastEvent));
        $this->assertTrue($upcoming->contains($unpublishedEvent));
    }

    /** @test */
    public function can_change_ticket_string()
    {
        $event = Event::factory()->make([
            'ticket_string' => 'ticket',
        ]);

        $this->assertEquals('Ticket', $event->ticket_string);

        $event->ticket_string = 'attendee';
        $event->save();

        $this->assertEquals('Attendee', $event->fresh()->ticket_string);
    }
}
