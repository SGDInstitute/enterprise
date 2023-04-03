<?php

namespace Tests\Feature\Livewire\App\Forms;

use App\Actions\InviteUser as ActionsInviteUser;
use App\Http\Livewire\App\Forms\Show;
use App\Mail\InviteUser as MailInviteUser;
use App\Models\Event;
use App\Models\Form;
use App\Models\Response;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function reminders_are_set_when_workshop_response_saved(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $form = Form::factory()->for($event)->preset('workshop')->create([
            'start' => now()->subDay(),
            'end' => now()->addMonth(),
            'settings' => [
                'reminders' => '1,3,7,-2',
            ],
        ]);
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Show::class, ['form' => $form])
            ->set('answers.question-name', 'Rubber Ducky')
            ->assertEmitted('notify');

        $this->assertNotNull($response = $user->responses()->where('form_id', $form->id)->first());

        $this->assertCount(0, $response->reminders);
    }

    /** @test */
    public function only_reminders_available_before_form_end_are_set_when_workshop_response_saved(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $form = Form::factory()->for($event)->preset('workshop')->create([
            'start' => now()->subDay(),
            'end' => now()->addDays(4),
            'settings' => [
                'reminders' => '1,3,7,-2',
            ],
        ]);
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Show::class, ['form' => $form])
            ->set('answers.question-name', 'Rubber Ducky')
            ->assertEmitted('notify');

        $this->assertNotNull($response = $user->responses()->where('form_id', $form->id)->first());

        $this->assertCount(0, $response->reminders);
    }

    /** @test */
    public function adding_collaborator_creates_an_invite()
    {
        Mail::fake();

        $event = Event::factory()->preset('mblgtacc')->create();
        $form = Form::factory()->for($event)->preset('workshop')->create([
            'start' => now()->subDay(),
            'end' => now()->addDays(4),
        ]);
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Show::class, ['form' => $form])
            ->set('answers.question-name', 'How to Save a World from an Evil Horde')
            ->set('newCollaborator.email', 'adora@eternia.gov')
            ->call('saveCollaborator')
            ->assertHasNoErrors()
            ->assertSee('adora@eternia.gov');

        $savedResponse = $user->responses()->where('form_id', $form->id)->first();
        $this->assertDatabaseMissing('users', ['email' => 'adora@eternia.gov']);
        $this->assertDatabaseHas('invitations', [
            'invited_by' => $user->id,
            'inviteable_type' => 'App\Models\Response', 
            'inviteable_id' => $savedResponse->id, 
            'email' => 'adora@eternia.gov',
        ]);

        Mail::assertSent(MailInviteUser::class, function (MailInviteUser $mail) {
            return $mail->hasTo('adora@eternia.gov');
        });
    }

    /** @test */
    public function can_remove_invite()
    {
        Mail::fake();

        $event = Event::factory()->preset('mblgtacc')->create();
        $form = Form::factory()->for($event)->preset('new-workshop')->create([
            'start' => now()->subDay(),
            'end' => now()->addDays(4),
        ]);
        $user = User::factory()->create();
        $response = Response::factory()->for($form)->for($user)->create(['answers' => [
            'question-name' => 'How to Save a World',
        ]]);
        $invitation = (new ActionsInviteUser)->invite($user, $response, 'adora@eternia.gov');

        Livewire::actingAs($user)
            ->withQueryParams(['edit' => $response->id])
            ->test(Show::class, ['form' => $form])
            ->assertSee('adora@eternia.gov')
            ->call('deleteInvitation', $invitation->id)
            ->assertHasNoErrors()
            ->assertDontSee('adora@eternia.gov');

        $this->assertDatabaseMissing('invitations', [
            'invited_by' => $user->id,
            'inviteable_type' => 'App\Models\Response', 
            'inviteable_id' => $response->id, 
            'email' => 'adora@eternia.gov',
        ]);
    }
}
