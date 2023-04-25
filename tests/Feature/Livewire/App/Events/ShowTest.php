<?php

namespace Tests\Feature\Livewire\App\Events;

use App\Http\Livewire\App\Events\Show;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_must_be_verified_before_filling()
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
            ->test(Show::class, ['event' => $event])
            ->assertSee('verify your email');
    }

    /** @test */
    public function can_generate_order_from_guide()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();
        TicketType::factory()->for($event)->count(2)
            ->state(new Sequence(
                ['name' => 'Expired', 'end' => now()->subDays(7)],
                ['name' => 'Available', 'end' => now()->addDays(7)],
            ))
            ->hasPrices(1)
            ->create();

        Livewire::actingAs($user)
            ->test(Show::class, ['event' => $event])
            ->set('guide.num_tickets', 2)
            ->set('guide.is_attending', '1')
            ->set('guide.payment', '0')
            ->call('generate')
            ->assertRedirect();

        $this->assertCount(1, $user->orders);
        $this->assertCount(2, $user->orders->first()->tickets);
        $this->assertTrue($user->hasTicketFor($event));
    }
}
