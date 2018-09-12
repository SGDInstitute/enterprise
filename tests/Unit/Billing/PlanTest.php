<?php

namespace Tests\Unit\Billing;

use App\Billing\Plan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanTest extends TestCase
{
    /** @test */
    function can_find_or_create_plan()
    {
        $monthly = Plan::findOrCreate('monthly-25', $this->key());
        $this->assertEquals($monthly->id, 'monthly-25');
        $this->assertEquals($monthly->interval, 'month');
        $this->assertEquals($monthly->interval_count, 1);

        $quarterly = Plan::findOrCreate('quarterly-25', $this->key());
        $this->assertEquals($quarterly->id, 'quarterly-25');
        $this->assertEquals($quarterly->interval, 'month');
        $this->assertEquals($quarterly->interval_count, 3);

        $yearly = Plan::findOrCreate('yearly-25', $this->key());
        $this->assertEquals($yearly->id, 'yearly-25');
        $this->assertEquals($yearly->interval, 'year');
        $this->assertEquals($yearly->interval_count, 1);

        $found = Plan::findOrCreate('monthly-25', $this->key());
        $this->assertEquals($found->id, 'monthly-25');
    }

    function key()
    {
        return config('institute.stripe.secret');
    }
}
