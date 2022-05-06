<?php

namespace Tests\Feature\Livewire\Galaxy\Events;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FlatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get("/galaxy/ticket-types/create/flat?event={$event->id}")
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.ticket-types.flat');
    }

    /** @test */
    public function can_save_new_flat_ticket_type()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();

        Livewire::actingAs($user)
            ->withQueryParams(['event' => $event->id])
            ->test('galaxy.ticket-types.flat')
            ->set('ticketType.name', 'In-person Attendee')
            ->set('ticketType.costInDollars', '85')
            ->set('ticketType.formattedStart', '04/04/2022 12:00 PM')
            ->set('ticketType.formattedEnd', '10/20/2022 12:00 PM')
            ->call('save')
            ->assertRedirect();

        $ticketType = $event->ticketTypes->first();

        $this->assertSame('In-person Attendee', $ticketType->name);
        $this->assertSame('2022-04-04 16:00:00', $ticketType->start->toDateTimeString());
        $this->assertSame('2022-10-20 16:00:00', $ticketType->end->toDateTimeString());
        $this->assertNotNull($ticketType->stripe_product_id);

        $price = $ticketType->prices->first();

        $this->assertSame('In-person Attendee', $price->name);
        $this->assertSame('2022-04-04 16:00:00', $price->start->toDateTimeString());
        $this->assertSame('2022-10-20 16:00:00', $price->end->toDateTimeString());
        $this->assertNotNull($price->stripe_price_id);
    }
}
