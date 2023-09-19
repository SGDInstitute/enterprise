<?php

namespace Tests\Feature\Livewire\App\Events;

use App\Livewire\App\Events\Show;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ShowTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_must_be_verified_before_filling(): void
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
}
