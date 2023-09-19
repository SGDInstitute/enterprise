<?php

namespace Tests\Feature\Livewire\App\Forms;

use App\Livewire\App\Forms\Show;
use App\Models\Event;
use App\Models\Form;
use App\Models\Response;
use App\Models\User;
use App\Notifications\AddedAsCollaborator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ShowTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
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
            ->assertDispatched('notify');

        $this->assertNotNull($response = $user->responses()->where('form_id', $form->id)->first());

        $this->assertCount(0, $response->reminders);
    }

    #[Test]
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
            ->assertDispatched('notify');

        $this->assertNotNull($response = $user->responses()->where('form_id', $form->id)->first());

        $this->assertCount(0, $response->reminders);
    }

    #[Test]
    public function adding_collaborator_creates_an_invite(): void
    {
        Notification::fake();

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

        Notification::assertSentOnDemand(AddedAsCollaborator::class);
    }

    #[Test]
    public function can_remove_invite(): void
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
        $invitation = $response->invitations()->create([
            'invited_by' => $user->id,
            'email' => 'adora@eternia.gov',
        ]);

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

    #[Test]
    public function user_must_be_verified_before_filling(): void
    {
        $event = Event::factory()->preset('mblgtacc')->create();
        $form = Form::factory()->for($event)->preset('new-workshop')->create([
            'start' => now()->subDay(),
            'end' => now()->addDays(4),
            'auth_required' => true,
        ]);
        $user = User::factory()->unverified()->create();

        Livewire::actingAs($user)
            ->test(Show::class, ['form' => $form])
            ->assertSee('verify your email')
            ->assertSet('fillable', false);
    }

    #[Test]
    public function can_confirm_if_accepted(): void
    {
        $user = User::factory()->create();
        $form = Form::factory()->create(['form' => [
            ['data' => ['id' => 'timeline-information', 'content' => '<h2>Application Timeline</h2>'], 'type' => 'content'],
            ['data' => ['id' => 'name', 'type' => 'text', 'question' => 'Name of Workshop'], 'type' => 'question'],
        ]]);
        $proposal = Response::factory()->for($form)->for($user)->create(['answers' => ['name' => 'Hello world'], 'status' => 'approved']);

        Livewire::actingAs($user)
            ->withQueryParams(['edit' => $proposal->id])
            ->test(Show::class, ['form' => $form])
            ->assertSee('Confirm Presentation')
            ->call('confirm');

        $this->assertEquals('confirmed', $proposal->fresh()->status);
    }
}
