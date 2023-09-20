<?php

namespace Tests\Feature\Livewire\App\Dashboard;

use App\Livewire\App\Dashboard\Donations;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class DonationsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_view_all_donations(): void
    {
        $user = User::factory()->create();
        Donation::factory()->count(5)->for($user)->create();

        Livewire::actingAs($user)
            ->test(Donations::class)
            ->assertCount('donations', 5);
    }
}
