<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
