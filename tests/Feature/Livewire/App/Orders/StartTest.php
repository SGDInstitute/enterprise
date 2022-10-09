<?php

namespace Tests\Feature\Livewire\App\Orders;

use App\Http\Livewire\App\Events\Tickets;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function expired_ticket_types_are_not_shown()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketTypes = TicketType::factory()->for($event)->count(2)
            ->state(new Sequence(
                ['name' => 'Available', 'end' => now()->addDays(7)],
                ['name' => 'Expired', 'end' => now()->subDays(7)],
            ))
            ->hasPrices(1)
            ->create();

        Livewire::actingAs($user)
            ->test(Tickets::class, ['event' => $event])
            ->assertOk()
            ->assertSee('Available')
            ->assertDontSee('Expired');
    }
}
