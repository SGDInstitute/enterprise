<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Http\Livewire\App\Orders\Attendee;
use Livewire\Livewire;
use Tests\TestCase;

class AttendeeTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Attendee::class);

        $component->assertStatus(200);
    }
}
