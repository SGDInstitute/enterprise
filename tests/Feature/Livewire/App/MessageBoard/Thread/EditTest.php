<?php

namespace Tests\Feature\Livewire\App\MessageBoard\Thread;

use App\Http\Livewire\App\MessageBoard\Thread\Edit;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Edit::class);

        $component->assertStatus(200);
    }
}
