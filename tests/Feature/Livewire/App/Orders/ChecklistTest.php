<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Livewire\App\Orders\Checklist;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ChecklistTest extends TestCase
{
    #[Test]
    public function the_component_can_render(): void
    {
        $component = Livewire::test(Checklist::class);

        $component->assertStatus(200);
    }
}
