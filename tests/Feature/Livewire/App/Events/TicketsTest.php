<?php

namespace Tests\Feature\Livewire\App\Events;

use App\Http\Livewire\App\Events\Tickets;
use App\Models\Event;
use App\Models\Price;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function expired_ticket_types_are_not_shown()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketTypes = TicketType::factory()->for($event)->count(2)
            ->state(new Sequence(
                ['name' => 'Expired', 'end' => now()->subDays(7)],
                ['name' => 'Available', 'end' => now()->addDays(7)],
            ))
            ->hasPrices(2)
            ->create();

        Livewire::actingAs($user)
            ->test(Tickets::class, ['event' => $event])
            ->assertOk()
            ->assertSee('Available')
            ->assertDontSee('Expired');
    }
}
