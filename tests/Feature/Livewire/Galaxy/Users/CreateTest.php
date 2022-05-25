<?php

namespace Tests\Feature\Livewire\Galaxy\Users;

use App\Http\Livewire\Galaxy\Users\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Create::class);

        $component->assertStatus(200);
    }
}
