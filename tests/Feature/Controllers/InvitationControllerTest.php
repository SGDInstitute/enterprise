<?php

namespace Tests\Feature\Controllers;

use App\Models\Event;
use App\Models\Form;
use App\Models\Invitation;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Notifications\InvitationAccepted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class InvitationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_accept_invitation_for_workshop(): void
    {
        Notification::fake();

        $creator = User::factory()->create(['email' => 'luz@hexide.edu']);
        $user = User::factory()->create(['email' => 'king@hexide.edu']);
        $response = Response::factory()->create();
        $invitation = Invitation::factory()->for($response, 'inviteable')->create(['email' => $user->email, 'invited_by' => $creator->id]);

        $this->actingAs($user)
            ->get($invitation->acceptUrl)
            ->assertRedirectToRoute('app.forms.show', ['form' => $response->form, 'edit' => $response]);

        $this->assertTrue($response->collaborators->contains($user->id));

        $this->assertDatabaseMissing('invitations', [
            'inviteable_type' => 'App\Models\Response',
            'inviteable_id' => $response->id,
            'email' => 'king@hexide.edu',
        ]);

        Notification::assertSentTo([$creator], InvitationAccepted::class);
    }

    #[Test]
    public function can_accept_invitation_for_ticket(): void
    {
        Notification::fake();

        $creator = User::factory()->create(['email' => 'luz@hexide.edu']);
        $user = User::factory()->create(['email' => 'king@hexide.edu']);
        $ticket = Ticket::factory()->create();
        $invitation = Invitation::factory()->for($ticket, 'inviteable')->create(['email' => $user->email, 'invited_by' => $creator->id]);

        $this->actingAs($user)
            ->get($invitation->acceptUrl)
            ->assertRedirectToRoute('app.orders.show', ['order' => $ticket->order]);

        $this->assertTrue($ticket->fresh()->user_id === $user->id);

        $this->assertDatabaseMissing('invitations', [
            'inviteable_type' => 'App\Models\Ticket',
            'inviteable_id' => $ticket->id,
            'email' => 'king@hexide.edu',
        ]);

        Notification::assertSentTo([$creator], InvitationAccepted::class);
    }

    #[Test]
    public function if_user_exists_but_is_not_logged_in_redirect_to_login_with_flash(): void
    {
        $user = User::factory()->create(['email' => 'luz@hexide.edu']);
        $response = Response::factory()->create();
        $invtation = Invitation::factory()->for($response, 'inviteable')->create(['email' => $user->email]);

        $this->get($invtation->acceptUrl)
            ->assertRedirectToRoute('login')
            ->assertSessionHas('status', 'Login to accept invitation.')
            ->assertSessionHas('url.intended', $invtation->acceptUrl);
    }

    #[Test]
    public function if_user_does_not_exist_redirect_to_register_with_flash(): void
    {
        $response = Response::factory()->create();
        $invtation = Invitation::factory()->for($response, 'inviteable')->create(['email' => 'luz@hexide.edu']);

        $this->get($invtation->acceptUrl)
            ->assertRedirectToRoute('register')
            ->assertSessionHas('status', 'Create an account to accept invitation.')
            ->assertSessionHas('url.intended', $invtation->acceptUrl);
    }

    #[Test]
    public function if_logged_in_user_does_not_match_log_them_out(): void
    {
        $user = User::factory()->create();
        $response = Response::factory()->create();
        $invtation = Invitation::factory()->for($response, 'inviteable')->create(['email' => 'luz@hexide.edu']);

        $this->actingAs($user)
            ->get($invtation->acceptUrl);

        $this->assertFalse(auth()->check());
    }

    #[Test]
    public function if_user_accepts_an_invitation_for_a_confirmed_or_scheduled_proposal_an_order_is_created()
    {
        Notification::fake();

        $event = Event::factory()->has(TicketType::factory()->withPrice()->count(2))->create();
        $creator = User::factory()->create(['email' => 'luz@hexide.edu']);
        $user = User::factory()->create(['email' => 'king@hexide.edu']);

        $form = Form::factory()->for($event)->create();
        $response = Response::factory()->for($form)->create(['status' => 'confirmed']);
        $invitation = Invitation::factory()->for($response, 'inviteable')->create(['email' => $user->email, 'invited_by' => $creator->id]);

        $this->actingAs($user)
            ->get($invitation->acceptUrl)
            ->assertRedirectToRoute('app.forms.show', ['form' => $response->form, 'edit' => $response]);

        $user->hasCompedTicketFor($response->form->event);

        Notification::assertSentTo([$creator], InvitationAccepted::class);
    }

    #[Test]
    public function lower_and_upper_case_differences_are_okay()
    {
        Notification::fake();

        $creator = User::factory()->create(['email' => 'luz@hexide.edu']);
        $user = User::factory()->create(['email' => 'King@hexide.edu']);
        $ticket = Ticket::factory()->create();
        $invitation = Invitation::factory()->for($ticket, 'inviteable')
            ->create([
                'email' => 'king@hexide.edu',
                'invited_by' => $creator->id,
            ]);

        $this->actingAs($user)
            ->get($invitation->acceptUrl)
            ->assertRedirectToRoute('app.orders.show', ['order' => $ticket->order]);

        $this->assertTrue($ticket->fresh()->user_id === $user->id);

        $this->assertDatabaseMissing('invitations', [
            'inviteable_type' => 'App\Models\Ticket',
            'inviteable_id' => $ticket->id,
            'email' => 'king@hexide.edu',
        ]);

        Notification::assertSentTo([$creator], InvitationAccepted::class);
    }
}
