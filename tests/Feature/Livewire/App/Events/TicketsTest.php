<?php

namespace Tests\Feature\Livewire\App\Events;

use App\Http\Livewire\App\Events\Tickets;
use App\Models\Event;
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
    public function expired_ticket_types_are_disabled(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketTypes = TicketType::factory()->for($event)->count(2)
            ->state(new Sequence(
                ['name' => 'Expired', 'end' => now()->subDays(7)],
                ['name' => 'Available', 'end' => now()->addDays(7)],
            ))
            ->hasPrices(1)
            ->create();

        Livewire::actingAs($user)
            ->test(Tickets::class, ['event' => $event])
            ->assertOk()
            ->set('form.0.amount', 2)
            ->call('reserve')
            ->assertHasErrors();
    }

    /** @test */
    public function inputs_are_disabled_if_user_is_unverified()
    {
        $user = User::factory()->unverified()->create();
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketTypes = TicketType::factory()->for($event)->count(2)
            ->state(new Sequence(
                ['name' => 'Expired', 'end' => now()->subDays(7)],
                ['name' => 'Available', 'end' => now()->addDays(7)],
            ))
            ->hasPrices(1)
            ->create();

        Livewire::actingAs($user)
            ->test(Tickets::class, ['event' => $event])
            ->assertSet('fillable', false);
    }
}
