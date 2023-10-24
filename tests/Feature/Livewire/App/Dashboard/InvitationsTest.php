<?php

namespace Tests\Feature\Livewire\App\Dashboard;

use App\Livewire\App\Dashboard\Donations;
use App\Livewire\App\Dashboard\Invitations;
use App\Models\Donation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_view_all_invitations(): void
    {
        $user = User::factory()->create();
        Invitation::factory()->create(['email' => $user->email]);

        Livewire::actingAs($user)
            ->test(Invitations::class)
            ->assertCount('invitations', 1);
    }

    #[Test]
    public function can_accept_invitation()
    {
        $user = User::factory()->create();
        Invitation::factory()->create(['email' => $user->email]);

        Livewire::actingAs($user)
            ->test(Invitations::class)
            ->assertCount('invitations', 1);
    }
}
