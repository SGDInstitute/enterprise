<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Actions\SafeDeleteBulkAction;
use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\ReservationsRelationManager;
use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EventResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_bulk_delete_reservations()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create();

        $reservations = Order::factory()
            ->for($event)
            ->has(Ticket::factory()->for($event)->for($ticketType)->for($price)->count(1))
            ->count(5)
            ->create();

        Livewire::test(ReservationsRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class])
            ->assertCanSeeTableRecords($reservations)
            ->callTableBulkAction(SafeDeleteBulkAction::class, $reservations);

        foreach ($reservations as $reservation) {
            $reservation->refresh();
            $this->assertNotNull($reservation->deleted_at);
            $this->assertEmpty($reservation->tickets);
        }
    }

    /** @test */
    public function can_bulk_delete_orders()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->for($event)->create();
        $price = Price::factory()->for($ticketType)->create();

        $orders = Order::factory()
            ->for($event)
            ->has(Ticket::factory()->for($event)->for($ticketType)->for($price)->count(1))
            ->paid()
            ->count(5)
            ->create();

        Livewire::test(OrdersRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class])
            ->assertCanSeeTableRecords($orders)
            ->callTableBulkAction(SafeDeleteBulkAction::class, $orders);

        foreach ($orders as $order) {
            $order->refresh();
            $this->assertNotNull($order->deleted_at);
            $this->assertEmpty($order->tickets);
        }
    }
}
