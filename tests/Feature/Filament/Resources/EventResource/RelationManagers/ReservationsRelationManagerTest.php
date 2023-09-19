<?php

namespace Tests\Feature\Filament\Resources\ResponseResource\Pages;

use PHPUnit\Framework\Attributes\Test;
use App\Filament\Actions\MarkAsPaidAction;
use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\RelationManagers\ReservationsRelationManager;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Test;
use Tests\TestCase;

class ReservationsRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_render_reservations(): void
    {
        $event = Event::factory()->create();
        Order::factory()->for($event)->count(5)->create();

        Livewire::test(ReservationsRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->assertSuccessful();
    }

    #[Test]
    public function can_only_view_reservations(): void
    {
        $event = Event::factory()->create();
        $order = Order::factory()->for($event)->paid()->create();
        $reservation = Order::factory()->for($event)->create();

        Livewire::test(ReservationsRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->assertCanSeeTableRecords([$reservation])
            ->assertCanNotSeeTableRecords([$order]);
    }

    #[Test]
    public function can_mark_order_as_paid(): void
    {
        $event = Event::factory()->create();
        $order = Order::factory()->for($event)->create();

        Livewire::test(ReservationsRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->callTableAction(MarkAsPaidAction::class, $order, [
                'check_number' => '123',
                'amount' => 10,
            ])
            ->assertHasNoTableActionErrors()
            ->assertNotified();

        $this->assertEquals('#123', $order->fresh()->transaction_id);
    }
}
