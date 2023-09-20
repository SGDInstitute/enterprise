<?php

namespace Tests\Feature\Livewire\App;

use App\Livewire\App\Home;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class HomeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_can_render(): void
    {
        $component = Livewire::test(Home::class);

        $component->assertStatus(200);
    }
}
