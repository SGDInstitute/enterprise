<?php

namespace Tests\Feature\Livewire\App\MessageBoard\Post;

use App\Http\Livewire\App\MessageBoard\Post\Edit;
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
