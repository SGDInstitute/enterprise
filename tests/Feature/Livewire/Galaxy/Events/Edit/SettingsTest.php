<?php

namespace Tests\Feature\Livewire\Galaxy\Events\Edit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/edit/settings')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.edit.settings');
    }

    /** @test */
    public function can_update_settings_for_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->preset('mblgtacc')->create([
            'settings' => [
                'reservations' => true,
            ]
        ]);

        Livewire::actingAs($user)
            ->test('galaxy.events.edit.settings', ['event' => $event])
            ->assertSet('event.settings.reservations', true)
            ->set('event.settings.reservations', false)
            ->call('save')
            ->assertSet('formChanged', false)
            ->assertEmitted('notify');

        $event->refresh();
        $this->assertEquals(false, $event->settings->reservations);
    }
}
