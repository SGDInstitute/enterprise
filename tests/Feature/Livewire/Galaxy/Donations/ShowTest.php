<?php

namespace Tests\Feature\Livewire\Galaxy\Donations;

use App\Http\Livewire\Galaxy\Donations\Show;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_donations_component_on_page()
    {
        $donation = Donation::factory()->create();
        $user = User::factory()->create()->assignRole('institute');

        $this->actingAs($user)
            ->get('/galaxy/donations/' . $donation->id)
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.donations.show');
    }

    /** @test */
    public function can_view_all_donations()
    {
        $donation = Donation::factory()->create([
            'transaction_id' => 'ch_123123',
            'subscription_id' => 'sub_123123',
            'type' => 'monthly',
            'amount' => 1000,
        ]);
        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test(Show::class, ['donation' => $donation])
            ->assertSee('ch_123123')
            ->assertSee('Recurring Monthly')
            ->assertSee('$10.00');
    }
}
