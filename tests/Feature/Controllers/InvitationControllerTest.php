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

    /** @test */
    public function if_user_exists_but_is_not_logged_in_redirect_to_login_with_flash()
    {
        $user = User::factory()->create(['email' => 'luz@hexide.edu']);
        $response = Response::factory()->create();
        $invtation = Invitation::factory()->for($response, 'inviteable')->create(['email' => $user->email]);

        $this->get($invtation->acceptUrl)
            ->assertRedirectToRoute('login')
            ->assertSessionHas('status', 'Login to accept invitation.')
            ->assertSessionHas('url.intended', $invtation->acceptUrl);
    }

    /** @test */
    public function if_user_does_not_exist_redirect_to_register_with_flash()
    {
        $response = Response::factory()->create();
        $invtation = Invitation::factory()->for($response, 'inviteable')->create(['email' => 'luz@hexide.edu']);

        $this->get($invtation->acceptUrl)
            ->assertRedirectToRoute('register')
            ->assertSessionHas('status', 'Create an account to accept invitation.')
            ->assertSessionHas('url.intended', $invtation->acceptUrl);
    }

    /** @test */
    public function if_logged_in_user_does_not_match_log_them_out()
    {
        $user = User::factory()->create();
        $response = Response::factory()->create();
        $invtation = Invitation::factory()->for($response, 'inviteable')->create(['email' => 'luz@hexide.edu']);

        $this->actingAs($user)
            ->get($invtation->acceptUrl);

        $this->assertFalse(auth()->check());
    }
}
