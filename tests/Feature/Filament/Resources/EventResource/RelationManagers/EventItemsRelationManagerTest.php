<?php

namespace Tests\Feature\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\RelationManagers\EventItemsRelationManager;
use App\Models\Event;
use App\Models\EventItem;
use App\Models\Response;
use App\Models\User;
use App\Notifications\WorkshopScheduled;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class EventItemsRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_event_item(): void
    {
        $event = Event::factory()->create();

        Livewire::test(EventItemsRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->callTableAction('create', data: [
                'name' => 'Workshop (Session 3)',
                'speaker' => null,
                'location' => null,
                'description' => null,
                'start' => '2023-11-04 09:00:00',
                'end' => '2023-11-04 09:45:00',
                'timezone' => 'America/New_York',
            ])
            ->assertHasNoActionErrors();

        $this->assertCount(1, $event->items);
        $item = $event->items->first();
        $this->assertEquals('Workshop (Session 3)', $item->name);
        $this->assertEquals('workshop-session-3', $item->slug);
        $this->assertEquals('2023-11-04 13:00:00', $item->start);
        $this->assertEquals('2023-11-04 13:45:00', $item->end);
        $this->assertEquals('America/New_York', $item->timezone);
    }

    /** @test */
    public function can_create_sub_item(): void
    {
        Notification::fake();

        $event = Event::factory()->create();
        $item = EventItem::factory()->for($event)->create([
            'name' => 'Workshop (Session 3)',
            'start' => '2023-11-04 13:00:00',
            'end' => '2023-11-04 13:45:00',
            'timezone' => 'America/New_York',
        ]);
        $response = Response::factory()
            ->hasCollaborators(User::factory())
            ->hasCollaborators(User::factory())
            ->create(['answers' => ['question-name' => 'One Piece']]);

        Livewire::test(EventItemsRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->callTableAction('create-sub', data: [
                'parent_id' => $item->id,
                'workshop_id' => $response->id,
                'location' => 'A123',
                'track' => 'rural',
            ])
            ->assertHasNoActionErrors();

        $item = $event->items->last();
        $this->assertEquals('One Piece', $item->name);
        $this->assertEquals(
            'one-piece',
            $item->slug
        );
        $this->assertEquals('2023-11-04 13:00:00', $item->start);
        $this->assertEquals('2023-11-04 13:45:00', $item->end);
        $this->assertEquals('America/New_York', $item->timezone);
        $this->assertEquals('A123', $item->location);
        $this->assertEquals(1, $item->settings->workshop_id);

        $this->assertEquals('scheduled', $response->fresh()->status);

        Notification::assertSentTo($response->collaborators, WorkshopScheduled::class);
    }
}
