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
    public function can_see_livewire_donations_component_on_page(): void
    {
        $donation = Donation::factory()->create([
            'transaction_id' => 'test_pi_123123',
            'subscription_id' => 'test_sub_123123',
            'type' => 'monthly',
            'amount' => 1000,
        ]);
        $user = User::factory()->create()->assignRole('institute');

        $this->actingAs($user)
            ->withoutExceptionHandling()
            ->get('/galaxy/donations/' . $donation->id)
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.donations.show');
    }

    /** @test */
    public function can_view_all_donations(): void
    {
        $donation = Donation::factory()->create([
            'transaction_id' => 'test_pi_123123',
            'subscription_id' => 'test_sub_123123',
            'type' => 'monthly',
            'amount' => 1000,
        ]);
        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test(Show::class, ['donation' => $donation])
            ->assertSee('test_pi_123123')
            ->assertSee('Recurring Monthly')
            ->assertSee('$10.00');
    }
}
