<?php

namespace Tests\Feature\Controllers;

use App\Models\Invitation;
use App\Models\Response;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationControllerTest extends TestCase
{
    use RefreshDatabase;

    // if user logged in with proper email can accept invitation
    /** @test */
    public function can_accept_invitation_for_workshop()
    {
        $user = User::factory()->create(['email' => 'luz@hexide.edu']);
        $response = Response::factory()->create();
        $invtation = Invitation::factory()->for($response, 'inviteable')->create(['email' => $user->email]);

        $this->actingAs($user)
            ->get($invtation->acceptUrl)
            ->assertRedirectToRoute('app.forms.show', ['form' => $response->form, 'edit' => $response]);

        $this->assertTrue($response->collaborators->contains($user->id));
    }

    // if user exists redirect to login with flash message

    // if user doesn't exist redirect to register with flash message

    // if user is logged in but not with email in question logout
}
