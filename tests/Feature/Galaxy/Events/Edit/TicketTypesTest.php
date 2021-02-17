<?php

namespace Tests\Feature\Galaxy\Events\Edit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTypesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/edit/tickets')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.edit.tickets');
    }

    /** @test */
    public function can_add_ticket_type_for_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();

        // Livewire::actingAs($user)
        //     ->test('galaxy.events.edit.tickets', ['event' => $event])
        //     ->call('add')
        //     ->assertS;
    }
}
