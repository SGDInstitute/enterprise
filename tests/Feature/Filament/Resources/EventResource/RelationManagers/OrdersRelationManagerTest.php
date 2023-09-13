<?php

namespace Tests\Feature\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\RelationManagers\EventItemsRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\OrdersRelationManager;
use App\Models\Event;
use App\Models\EventItem;
use App\Models\Order;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\WorkshopScheduled;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class OrdersRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_render_paid_orders(): void
    {
        $event = Event::factory()->create();
        Order::factory()->for($event)->paid()->count(5)->create();

        Livewire::test(OrdersRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->assertSuccessful();
    }

    /** @test */
    public function can_only_view_paid_orders(): void
    {
        $event = Event::factory()->create();
        $order = Order::factory()->for($event)-> paid()->create();
        $reservation = Order::factory()->for($event)->create();

        Livewire::test(OrdersRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->assertCanSeeTableRecords([$order])
            ->assertCanNotSeeTableRecords([$reservation]);
    }
}
