<?php

namespace Tests\Feature\Livewire\Galaxy\Events\Edit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Livewire\Livewire;
use App\Models\TicketType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/edit/tickets')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.edit.tickets');
    }

    /** @test */
    // public function can_create_ticket_type_for_event()
    // {
    //     $user = User::factory()->create()->assignRole('institute');
    //     $event = Event::factory()->preset('mblgtacc')->create();

    //     Livewire::actingAs($user)
    //         ->test('galaxy.events.edit.tickets', ['event' => $event])
    //         ->call('showCreateModal')
    //         ->assertSet('showModal', true)
    //         ->set('editing.name', 'Regular Registration')
    //         ->set('editing.type', 'regular')
    //         ->set('costInDollars', '85')
    //         ->set('formattedStart', '04/05/2021 12:00 PM')
    //         ->set('formattedEnd', '08/15/2021 11:59 PM')
    //         ->call('save')
    //         ->assertSet('showModal', false)
    //         ->assertEmitted('notify')
    //         ->assertSee('Regular Registration')
    //         ->assertSee('regular')
    //         ->assertSee('04/05/2021 12:00 PM')
    //         ->assertSee('08/15/2021 11:59 PM');
    // }

    /** @test */
    // public function can_edit_ticket_type_for_event()
    // {
    //     $user = User::factory()->create()->assignRole('institute');
    //     $event = Event::factory()->preset('mblgtacc')->create();
    //     $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

    //     Livewire::actingAs($user)
    //     ->test('galaxy.events.edit.tickets', ['event' => $event])
    //         ->call('showEditModal', $ticketType->id)
    //         ->assertSet('showModal', true)
    //         ->assertSee('Edit')
    //         ->set('editing.name', 'Regular Registration')
    //         ->set('editing.type', 'regular')
    //         ->set('costInDollars', '85')
    //         ->set('formattedStart', '04/05/2021 12:00 PM')
    //         ->set('formattedEnd', '08/15/2021 11:59 PM')
    //         ->call('save')
    //         ->assertSet('showModal', false)
    //         ->assertEmitted('notify')
    //         ->assertSee('Regular Registration')
    //         ->assertSee('regular')
    //         ->assertSee('04/05/2021 12:00 PM')
    //         ->assertSee('08/15/2021 11:59 PM');
    // }

    /** @test */
    public function can_delete_ticket_type_for_event()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

        Livewire::actingAs($user)
        ->test('galaxy.events.edit.tickets', ['event' => $event])
            ->call('remove', $ticketType->id)
            ->assertEmitted('notify')
            ->assertEmitted('refresh');
    }
}
