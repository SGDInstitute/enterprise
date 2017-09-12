<?php

namespace Tests\Unit;

use App\TicketType;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTypeTest extends TestCase
{
    /** @test */
    function can_view_formatted_cost()
    {
        $ticket = factory(TicketType::class)->make([
            'event_id' => 1,
            'cost' => 10000
        ]);

        $this->assertEquals('$100.00', $ticket->formatted_cost);
    }

    /** @test */
    function can_view_if_open()
    {
        $openTicket = factory(TicketType::class)->make([
            'event_id' => 1,
            'availability_start' => Carbon::parse('-1 week'),
            'availability_end' => Carbon::parse('+1 week')
        ]);
        $closedTicket = factory(TicketType::class)->make([
            'event_id' => 1,
            'availability_start' => Carbon::parse('+1 week'),
            'availability_end' => Carbon::parse('+1 month')
        ]);
        $alwaysOpenTicket = factory(TicketType::class)->make([
            'event_id' => 1,
            'availability_start' => null,
            'availability_end' => null
        ]);

        $this->assertTrue($openTicket->is_open);
        $this->assertFalse($closedTicket->is_open);
        $this->assertTrue($alwaysOpenTicket->is_open);
    }
}
