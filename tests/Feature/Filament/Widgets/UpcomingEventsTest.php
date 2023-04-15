<?php

namespace Tests\Feature\Filament\Widgets;

use App\Filament\Widgets\UpcomingEvents;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UpcomingEventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_future_and_current_events()
    {
        $future = Event::factory()->future()->create();
        $current = Event::factory()->current()->create();
        $past = Event::factory()->past()->create();
 
        Livewire::test(UpcomingEvents::class)
            ->assertCanSeeTableRecords([$future, $current])
            ->assertCanNotSeeTableRecords([$past]);
    }
}
