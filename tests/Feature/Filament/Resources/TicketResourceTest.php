<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\TicketResource;
use App\Filament\Resources\TicketTypeResource\Pages\CreateTicketType;
use App\Filament\Resources\TicketTypeResource\Pages\EditTicketType;
use App\Models\Event;
use App\Models\Price;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class TicketResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_view_complete_ticket()
    {
        $user = User::factory()->admin()->create();
        $ticket = Ticket::factory()->completed()->create();

        $this->actingAs($user)
            ->get(TicketResource::getUrl('view', ['record' => $ticket]))
            ->assertOk();
    }

    #[Test]
    public function can_view_invited_ticket()
    {
        $user = User::factory()->admin()->create();
        $ticket = Ticket::factory()->invited()->create();

        $this->actingAs($user)
            ->get(TicketResource::getUrl('view', ['record' => $ticket]))
            ->assertOk();
    }

    #[Test]
    public function can_view_unassigned_ticket()
    {
        $user = User::factory()->admin()->create();
        $ticket = Ticket::factory()->create();

        $this->actingAs($user)
            ->get(TicketResource::getUrl('view', ['record' => $ticket]))
            ->assertOk();
    }
}
