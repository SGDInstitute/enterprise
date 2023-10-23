<?php

namespace Tests\Feature\Livewire\App;

use App\Livewire\App\Home;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class HomeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_home()
    {
        $this->get(route('app.home'))
            ->assertOk();
    }

    #[Test]
    public function the_component_can_render(): void
    {
        Livewire::test(Home::class)
            ->assertOk();
    }
}
