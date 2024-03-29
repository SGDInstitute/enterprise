<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Livewire\App\Orders\Attendee;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AttendeeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_can_render(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $ticket = Ticket::factory()->for($user)->for($order)->create();

        Livewire::actingAs($user)->test(Attendee::class, ['order' => $order])
            ->assertStatus(200);
    }
}
