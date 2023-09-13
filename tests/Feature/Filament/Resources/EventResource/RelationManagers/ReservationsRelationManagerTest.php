<?php

namespace Tests\Feature\Filament\Resources\ResponseResource\Pages;

use App\Filament\Actions\MarkAsPaidAction;
use App\Filament\Actions\MarkAsUnpaidAction;
use App\Filament\Actions\RefundAction;
use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\ReservationsRelationManager;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Notifications\Refund;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use PHPUnit\Framework\Test;
use Tests\TestCase;

class ReservationsRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
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

    /** @test */
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

    /** @test */
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

    /** @test */
    public function cannot_mark_order_as_unpaid_if_processed_through_stripe(): void
    {
        $event = Event::factory()->create();
        $order = Order::factory()->for($event)->paid()->create([
            'transaction_id' => 'pi_test_1234',
        ]);

        Livewire::test(OrdersRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->assertTableActionDisabled(MarkAsUnpaidAction::class, $order);

        $this->assertNotNull($order->fresh()->transaction_id);
    }

    /** @test */
    public function can_refund_ticket_on_order(): void
    {
        Notification::fake();

        $event = Event::factory()->create();
        $order = Order::factory()->for($event)->paid()->create([
            'amount' => 2000,
        ]);
        [$ticketA, $ticketB] = Ticket::factory()->for($order)->for($event)->count(2)->create();

        Livewire::test(OrdersRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])->callTableAction(RefundAction::class, $order, data: [
            $ticketA->id => true,
        ]);

        $this->assertSoftDeleted($ticketA);
        $this->assertNotSoftDeleted($ticketB);
        $this->assertEquals(1000, $order->fresh()->amount);

        Notification::assertSentTo($order->user, Refund::class);
    }

    /** @test */
    public function can_refund_entire_order(): void
    {
        Notification::fake();

        $event = Event::factory()->create();
        $order = Order::factory()->for($event)->paid()->create([
            'amount' => 2000,
        ]);
        [$ticketA, $ticketB] = Ticket::factory()->for($order)->for($event)->count(2)->create();

        Livewire::test(OrdersRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])->callTableAction(RefundAction::class, $order, data: [
            $ticketA->id => true,
            $ticketB->id => true,
        ]);

        $this->assertSoftDeleted($ticketA);
        $this->assertSoftDeleted($ticketB);
        $this->assertSoftDeleted($order);

        Notification::assertSentTo($order->user, Refund::class);
    }
}
