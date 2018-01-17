<?php

namespace Tests\Feature\Admin;

use App\Event;
use App\Order;
use App\User;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Billing\StripePaymentGateway;
use App\TicketType;

class ViewOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function view_orders_for_event()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');
        $event = factory(Event::class)->create();
        $orders = factory(Order::class, 5)->create(['event_id' => $event->id]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/admin/events/{$event->slug}/orders");

        $response->assertStatus(200)
            ->assertViewHas('orders', function ($viewOrders) use ($orders) {
                return $orders->pluck('id')->all() === $viewOrders->pluck('id')->all();
            });
    }

    /** @test */
    public function view_single_order()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');
        $event = factory(Event::class)->create();
        $order = factory(Order::class)->create(['event_id' => $event->id]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/admin/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertViewHas('order', function ($viewOrder) use ($order) {
                return $order->id === $viewOrder->id;
            });
    }

    /** @test */
    public function view_paid_order()
    {
        Permission::create(['name' => 'view_dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view_dashboard');

        $event = factory(Event::class)->states('published')->create([
            'title' => 'Leadership Conference',
            'slug' => 'leadership-conference',
            'start' => '2018-02-16 19:00:00',
            'end' => '2018-02-18 19:30:00',
            'timezone' => 'America/Chicago',
            'place' => 'University of Nebraska',
            'location' => 'Omaha, Nebraska',
            'stripe' => 'mblgtacc',
        ]);
        $ticketType = $event->ticket_types()->save(factory(TicketType::class)->make([
            'cost' => 5000,
            'name' => 'Regular Ticket',
        ]));
        $order = $event->orderTickets($user, [
            ['ticket_type_id' => $ticketType->id, 'quantity' => 2]
        ]);

        $paymentGateway = new StripePaymentGateway(config('mblgtacc.stripe.secret'));
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $order->markAsPaid($paymentGateway->charge($order->amount, $paymentGateway->getValidTestToken()));

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/admin/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertViewHas('order', function ($viewOrder) use ($order) {
                return $order->id === $viewOrder->id;
            })
            ->assertSee('4242');
    }
}
