<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Event;
use Carbon\Carbon;

class EventTest extends TestCase
{
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
