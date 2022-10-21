<?php

namespace Tests\Feature\Livewire\App\Dashboard;

use App\Http\Livewire\App\Dashboard\Donations;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DonationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_all_donations()
    {
        $user = User::factory()->create();
        Donation::factory()->count(5)->for($user)->create();

        Livewire::actingAs($user)
            ->test(Donations::class)
            ->assertCount('donations', 5);
    }
}
