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
        Permission::create(['name' => 'view dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view dashboard');
        $event = factory(Event::class)->create();
        factory(Order::class, 5)->create(['event_id' => $event->id]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/admin/events/{$event->slug}/orders");

        $response->assertStatus(200)
            ->assertViewHas('orders', Order::all());
    }
}
