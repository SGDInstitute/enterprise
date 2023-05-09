<?php

namespace Tests\Feature\Livewire\App;

use App\Http\Livewire\App\MessageBoard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class MessageBoardTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(MessageBoard::class);

        $component->assertStatus(200);
    }
}
