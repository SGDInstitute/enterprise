<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventsController
 */
class EventsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_published_event()
    {
        $event = Event::factory()->published()->create([
            'title' => 'MBLGTACC 2018',
            'slug' => 'mblgtacc-2018',
            'subtitle' => 'All Roads Lead to Intersectionality',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
            'description' => 'Bacon ipsum dolor amet rump andouille landjaeger ham shoulder.',
            'links' => [
                ['icon' => 'twitter', 'link' => 'https://twitter.com/mblgtacc', 'order' => 1],
                ['icon' => 'facebook', 'link' => 'https://facebook.com/mblgtacc/', 'order' => 2],
                ['icon' => 'instagram', 'link' => 'https://instagram.com/mblgtacc', 'order' => 3],
                ['icon' => 'snapchat-ghost', 'link' => 'https://snapchat.com/add/mblgtacc', 'order' => 4],
                ['icon' => 'website', 'link' => 'https://mblgtacc.org', 'order' => 5],
            ],
            'image' => 'https://mblgtacc.org/themes/mblgtacc2018/assets/images/arts-and-sciences-fall.jpg',
            'logo_light' => 'https://mblgtacc.org/themes/mblgtacc2018/assets/images/mblgtacc-2018-horiz_White.png',
            'logo_dark' => 'https://mblgtacc.org/themes/mblgtacc2018/assets/images/mblgtacc-2018-horiz_Gray.png',
        ]);
        $regular = TicketType::factory()->make([
            'cost' => 6500,
            'name' => 'Regular Ticket',
        ]);
        $late = TicketType::factory()->make([
            'cost' => 8500,
            'name' => 'Late Ticket',
            'description' => 'You are not guaranteed to receive a conference T-shirt, program, or other memorabilia.',
        ]);

        $event->ticket_types()->save($regular);
        $event->ticket_types()->save($late);

        $response = $this->withoutExceptionHandling()->get("/events/{$event->slug}");

        $response->assertStatus(200);
        $response->assertSee('MBLGTACC 2018');
        $response->assertSee('All Roads Lead to Intersectionality');
        $response->assertSee('University of Nebraska');
        $response->assertSee('Omaha, Nebraska');
        $response->assertSee('Friday February 16, 2018 1:00 PM to Sunday February 18, 2018 1:30 PM CST');
        $response->assertSee('https://facebook.com/mblgtacc');
        $response->assertSee('https://twitter.com/mblgtacc');
        $response->assertSee('https://instagram.com/mblgtacc');
        $response->assertSee('https://mblgtacc.org');
        $response->assertSee('$65.00');
        $response->assertSee('Regular Ticket');
        $response->assertSee('$85.00');
        $response->assertSee('Late Ticket');
        $response->assertSee('You are not guaranteed to receive a conference T-shirt, program, or other memorabilia.');
    }

    /** @test */
    public function cannot_view_unpublished_event()
    {
        $event = Event::factory()->create([
            'published_at' => null,
        ]);
        $event->ticket_types()->save(TicketType::factory()->make());

        $response = $this->get("/events/{$event->slug}");

        $response->assertStatus(404);
    }

    /** @test */
    public function cannot_view_event_with_published_at_date_in_future()
    {
        $event = Event::factory()->create([
            'published_at' => Carbon::parse('+1 week'),
        ]);
        $event->ticket_types()->save(TicketType::factory()->make());

        $response = $this->get("/events/{$event->slug}");

        $response->assertStatus(404);
    }
}
