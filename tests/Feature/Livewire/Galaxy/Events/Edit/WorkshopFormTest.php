<?php

namespace Tests\Feature\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use App\Models\Form;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WorkshopFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/edit/workshops')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.edit.workshop-form');
    }

    /** @test */
    public function can_set_reminders()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();
        $this->workshopForm = Form::create([
            'event_id' => $event->id,
            'type' => 'workshop',
            'name' => $event->name . ' Workshop Proposal',
            'timezone' => $event->timezone,
        ]);

        Livewire::actingAs($user)
            ->test('galaxy.events.edit.workshop-form', ['event' => $event])
            ->set('reminders', '1,3,7,-2')
            ->call('save');

        $this->assertTrue($event->workshopForm->fresh()->has_reminders);
    }
}
