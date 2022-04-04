<?php

namespace Tests\Feature\Livewire\App;

use App\Http\Livewire\App\Home;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Home::class);

        $component->assertStatus(200);
    }
}
