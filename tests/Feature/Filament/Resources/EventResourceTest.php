<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Actions\SafeDeleteBulkAction;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\ReservationsRelationManager;
use App\Models\Event;
use App\Models\Order;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Notifications\EventCheckIn;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class EventResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_view_events(): void
    {
        $user = User::factory()->admin()->create();
        Event::factory()->count(2)->create();

        $this->actingAs($user)
            ->get(EventResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    public function can_edit_event(): void
    {
        $user = User::factory()->admin()->create();
        $event = Event::factory()->create();

        $this->actingAs($user)
            ->get(EventResource::getUrl('edit', ['record' => $event]))
            ->assertOk();
    }

    #[Test]
    public function can_bulk_delete_reservations(): void
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

    #[Test]
    public function can_bulk_delete_orders(): void
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

    #[Test]
    public function can_open_registration()
    {
        Notification::fake();

        $user = User::factory()->admin()->create();
        $event = Event::factory()->create();
        $paidOrder = Order::factory()->for($event)->paid()->create();
        Ticket::factory()->for($event)->for($paidOrder)->for($user)->create();
        $unpaidOrder = Order::factory()->for($event)->create();
        Ticket::factory()->for($event)->for($unpaidOrder)->for(User::factory())->create();

        Livewire::actingAs($user)
            ->test(EditEvent::class, [
                'record' => $event->getRouteKey(),
            ])
            ->callAction('open-checkin')
            ->assertHasNoActionErrors();

        $this->assertTrue($event->fresh()->settings->allow_checkin);

        Notification::assertSentTimes(EventCheckIn::class, 1);
    }
}
