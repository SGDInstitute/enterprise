<?php

namespace Tests\Feature\Filament\Resources\ResponseResource\Pages;

use App\Filament\Actions\MarkAsUnpaidAction;
use App\Filament\Actions\RefundAction;
use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\RelationManagers\OrdersRelationManager;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Notifications\Refund;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use PHPUnit\Framework\Test;
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
        $order = Order::factory()->for($event)->paid()->create();
        $reservation = Order::factory()->for($event)->create();

        Livewire::test(OrdersRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->assertCanSeeTableRecords([$order])
            ->assertCanNotSeeTableRecords([$reservation]);
    }

    /** @test */
    public function can_mark_order_as_unpaid(): void
    {
        $event = Event::factory()->create();
        $order = Order::factory()->for($event)->paid()->create();

        Livewire::test(OrdersRelationManager::class, [
            'ownerRecord' => $event,
            'pageClass' => EditEvent::class,
        ])
            ->callTableAction(MarkAsUnpaidAction::class, $order)
            ->assertNotified();

        $this->assertNull($order->fresh()->transaction_id);
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
            'amount' => 2000
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
            'amount' => 2000
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
