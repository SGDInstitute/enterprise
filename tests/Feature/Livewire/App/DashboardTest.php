<?php

namespace Tests\Feature\Livewire\App;

use App\Livewire\App\Dashboard;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DashboardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_app_dashboard()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('app.dashboard'))
            ->assertOk();
    }

    #[Test]
    public function the_component_can_render(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Dashboard::class)
            ->assertStatus(200);
    }

    #[Test]
    public function by_default_the_page_is_orders_resources()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Dashboard::class)
            ->assertSet('page', 'orders-reservations');
    }

    #[Test]
    public function if_user_has_invitations_that_becomes_default_page()
    {
        $user = User::factory()->create(['email' => 'adora@eternia.gov']);
        $order = Order::factory()->hasTickets(1)->create();
        $order->tickets->first()->invite('adora@eternia.gov', $order->user);

        Livewire::actingAs($user)
            ->test(Dashboard::class)
            ->assertSet('page', 'invitations');
    }

    #[Test]
    public function can_switch_pages_with_pending_invitations()
    {
        $user = User::factory()->create(['email' => 'adora@eternia.gov']);
        $order = Order::factory()->hasTickets(1)->create();
        $order->tickets->first()->invite('adora@eternia.gov', $order->user);

        Livewire::actingAs($user)
            ->test(Dashboard::class, ['page' => 'orders-reservations'])
            ->assertSet('page', 'orders-reservations');
    }
}
