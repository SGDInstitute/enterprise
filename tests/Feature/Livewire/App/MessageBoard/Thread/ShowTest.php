<?php

namespace Tests\Feature\Livewire\App\MessageBoard\Thread;

use App\Http\Livewire\App\MessageBoard\Thread\Show;
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
