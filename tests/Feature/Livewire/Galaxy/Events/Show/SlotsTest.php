<?php

namespace Tests\Feature\Livewire\Galaxy\Events\Show;

use App\Http\Livewire\Galaxy\Events\Show\Slots;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SlotsTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Slots::class);

        $component->assertStatus(200);
    }
}
