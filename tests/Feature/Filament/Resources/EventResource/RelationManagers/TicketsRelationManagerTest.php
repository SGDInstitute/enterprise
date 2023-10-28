<?php

namespace Tests\Feature\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\RelationManagers\TicketsRelationManager;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class TicketsRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function component_can_render()
    {
        $event = Event::factory()->create();
        Ticket::factory()->for($event)->count(5)->create();

        Livewire::test(TicketsRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])->assertSuccessful();
    }
}
