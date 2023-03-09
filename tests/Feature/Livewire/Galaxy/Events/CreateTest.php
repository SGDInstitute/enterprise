<?php

namespace Tests\Feature\Livewire\Galaxy\Events;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_events_create_component_on_events_create_page(): void
    {
        $user = User::factory()->create()->assignRole('institute');

        $this->actingAs($user)
            ->get('/galaxy/events/create')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.create');
    }

    /** @test */
    public function can_create_event(): void
    {
        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test('galaxy.events.create')
            ->set('event.name', 'MBLGTACC')
            ->set('event.start', '10/15/2021 5:00 PM') // should be able to set in desired timezone and converted to UTC
            ->set('event.end', '10/17/2021 1:00 PM') // should be able to set in desired timezone and converted to UTC
            ->set('event.timezone', 'America/Chicago') // should be able to set in desired timezone and converted to UTC
            ->set('event.location', 'Maddison, Wisconsin')
            ->set('event.order_prefix', 'MBL')
            ->set('event.description', 'MBLGTACC is the longest running blah blah blah.')
            ->set('event.settings.reservations', true)
            ->set('event.settings.volunteer_discounts', true)
            ->set('event.settings.presenter_discounts', true)
            ->set('event.settings.demographics', true)
            ->set('event.settings.add_ons', true)
            ->set('event.settings.bulk', true)
            ->set('event.settings.invoices', true)
            ->set('event.settings.check_payment', true)
            ->set('event.settings.onsite', true)
            ->set('event.settings.livestream', false)
            ->set('event.settings.has_workshops', true)
            ->set('event.settings.has_volunteers', true)
            ->set('event.settings.has_sponsorship', true)
            ->set('event.settings.has_vendors', true)
            ->set('event.settings.has_ads', true)
            ->set('event.settings.allow_donations', true)
            ->call('save')
            ->assertRedirect();

        $event = Event::whereName('MBLGTACC')->first();
        $this->assertEquals('MBLGTACC', $event->name);
        $this->assertEquals(Carbon::parse('2021-10-15 22:00:00'), $event->start);
        $this->assertEquals(Carbon::parse('2021-10-17 18:00:00'), $event->end);
        $this->assertEquals([
            'reservations' => true,
            'volunteer_discounts' => true,
            'presenter_discounts' => true,
            'demographics' => true,
            'add_ons' => true,
            'bulk' => true,
            'invoices' => true,
            'check_payment' => true,
            'onsite' => true,
            'livestream' => false,
            'has_workshops' => true,
            'has_volunteers' => true,
            'has_sponsorship' => true,
            'has_vendors' => true,
            'has_ads' => true,
            'allow_donations' => true,
        ], $event->settings->toArray());
    }

    /** @test */
    public function can_create_event_with_preset(): void
    {
        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test('galaxy.events.create')
            ->set('preset', 'mblgtacc')
            ->assertSet('event.name', 'MBLGTACC 20XX')
            ->assertSet('event.timezone', 'America/New_York')
            ->assertSet('event.order_prefix', 'MBL')
            ->assertSet('event.settings.reservations', true)
            ->assertSet('event.settings.volunteer_discounts', true)
            ->assertSet('event.settings.presenter_discounts', true)
            ->assertSet('event.settings.demographics', true)
            ->assertSet('event.settings.add_ons', true)
            ->assertSet('event.settings.bulk', true)
            ->assertSet('event.settings.invoices', true)
            ->assertSet('event.settings.check_payment', true)
            ->assertSet('event.settings.onsite', true)
            ->assertSet('event.settings.livestream', false)
            ->assertSet('event.settings.has_workshops', true)
            ->assertSet('event.settings.has_volunteers', true)
            ->assertSet('event.settings.has_sponsorship', true)
            ->assertSet('event.settings.has_vendors', true)
            ->assertSet('event.settings.has_ads', true)
            ->assertSet('event.settings.allow_donations', true);
    }
}
