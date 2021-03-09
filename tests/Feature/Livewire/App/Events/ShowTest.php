<?php

namespace Tests\Feature\Livewire\App\Events;

use App\Http\Livewire\App\Events\Show;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Show::class);

        $component->assertStatus(200);
    }
}
