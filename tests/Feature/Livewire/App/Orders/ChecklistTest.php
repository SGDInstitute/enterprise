<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Http\Livewire\App\Orders\Checklist;
use Livewire\Livewire;
use Tests\TestCase;

class ChecklistTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Checklist::class);

        $component->assertStatus(200);
    }
}
