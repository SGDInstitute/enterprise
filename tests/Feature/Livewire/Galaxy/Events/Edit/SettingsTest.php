<?php

namespace Tests\Feature\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create()->assignRole('institute');
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
                'reservation_length' => 60,
                'volunteer_discounts' => false,
                'presenter_discounts' => false,
                'demographics' => false,
                'add_ons' => false,
                'invoices' => false,
                'check_payment' => false,
                'onsite' => false,
                'livestream' => false,
                'has_workshops' => false,
                'has_volunteers' => false,
                'has_sponsorship' => false,
                'has_vendors' => false,
                'has_ads' => false,
                'allow_donations' => false,
            ],
        ]);

        Livewire::actingAs($user)
            ->test('galaxy.events.edit.settings', ['event' => $event])
            ->assertSet('event.settings.reservations', true)
            ->set('event.settings.reservations', false)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('formChanged', false)
            ->assertEmitted('notify');

        $event->refresh();
        $this->assertEquals(false, $event->settings->reservations);
    }
}
