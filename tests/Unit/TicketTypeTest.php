<?php

namespace Tests\Unit;

use App\TicketType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTypeTest extends TestCase
{
    /** @test */
    function can_view_formatted_cost()
    {
        $ticket = factory(TicketType::class)->make([
            'cost' => 10000
        ]);

        $this->assertEquals('$100.00', $ticket->formatted_cost);
    }
}
