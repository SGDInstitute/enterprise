<?php

namespace Tests\Feature\Livewire\App\Orders;

use PHPUnit\Framework\Attributes\Test;
use App\Livewire\App\Orders\Checklist;
use Livewire\Livewire;
use Tests\TestCase;

class ChecklistTest extends TestCase
{
    #[Test]
    public function the_component_can_render()
    {
        $component = Livewire::test(Checklist::class);

        $component->assertStatus(200);
    }
}
