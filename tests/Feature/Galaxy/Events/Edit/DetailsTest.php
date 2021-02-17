<?php

namespace Tests\Feature\Galaxy\Events\Edit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Livewire\Livewire;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/edit/details')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.edit.details');
    }

    /** @test */
    public function can_update_details_for_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create([
            'start' => '2021-10-01 21:00:00',
            'end' => '2021-10-03 17:00:00',
        ]);

        Livewire::actingAs($user)
            ->test('galaxy.events.edit.details', ['event' => $event])
            ->assertSet('formattedStart', '10/01/2021 5:00 PM')
            ->assertSet('formattedEnd', '10/03/2021 1:00 PM')
            ->set('event.name', 'MBLGTACC 2021')
            ->set('formattedStart', '10/15/2021 5:00 PM') // should be able to set in desired timezone and converted to UTC
            ->set('formattedEnd', '10/17/2021 1:00 PM') // should be able to set in desired timezone and converted to UTC
            ->set('event.timezone', 'America/Chicago') // should be able to set in desired timezone and converted to UTC
            ->set('event.location', 'Maddison, Wisconsin')
            ->set('event.order_prefix', 'MBL')
            ->set('event.description', 'MBLGTACC is the longest running blah blah blah.')
            ->assertSet('formChanged', true)
            ->call('save')
            ->assertSet('formChanged', false)
            ->assertEmitted('notify');

        $event->refresh();
        $this->assertEquals('MBLGTACC 2021', $event->name);
        $this->assertEquals(Carbon::parse('2021-10-15 22:00:00'), $event->start);
        $this->assertEquals(Carbon::parse('2021-10-17 18:00:00'), $event->end);
        $this->assertEquals('America/Chicago', $event->timezone);
        $this->assertEquals('Maddison, Wisconsin', $event->location);
        $this->assertEquals('MBL', $event->order_prefix);
        $this->assertEquals('MBLGTACC is the longest running blah blah blah.', $event->description);
    }
}
