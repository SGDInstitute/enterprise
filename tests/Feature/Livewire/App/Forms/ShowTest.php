<?php

namespace Tests\Feature\Livewire\App\Forms;

use App\Http\Livewire\App\Forms\Show;
use App\Models\Event;
use App\Models\Form;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function reminders_are_set_when_workshop_response_saved()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $form = Form::factory()->for($event)->preset('workshop')->create([
            'start' => now()->subDay(),
            'end' => now()->addMonth(),
            'settings' => [
                'reminders' => '1,3,7,-2',
            ]
        ]);
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Show::class, ['form' => $form])
            ->set('answers.question-name', 'Rubber Ducky')
            ->assertEmitted('notify');

        $this->assertNotNull($response = $user->responses()->where('form_id', $form->id)->first());

        $this->assertCount(4, $response->reminders);
    }

    /** @test */
    public function only_reminders_available_before_form_end_are_set_when_workshop_response_saved()
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $form = Form::factory()->for($event)->preset('workshop')->create([
            'start' => now()->subDay(),
            'end' => now()->addDays(4),
            'settings' => [
                'reminders' => '1,3,7,-2',
            ]
        ]);
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Show::class, ['form' => $form])
            ->set('answers.question-name', 'Rubber Ducky')
            ->assertEmitted('notify');

        $this->assertNotNull($response = $user->responses()->where('form_id', $form->id)->first());

        $this->assertCount(3, $response->reminders);
    }
}
