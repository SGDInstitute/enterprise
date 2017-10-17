<?php

namespace Tests\Feature\Admin;

use App\Event;
use App\Order;
use App\User;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function view_orders_for_event()
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
            ->assertViewHas('orders', function($viewOrders) use ($orders) {
                return $orders->pluck('id')->all() === $viewOrders->pluck('id')->all();
            });
    }

    /** @test */
    function view_single_order()
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
}
