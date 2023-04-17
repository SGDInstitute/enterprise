<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages\ListDonations;
use App\Filament\Resources\DonationResource\Pages\ViewDonation;
use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DonationsResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_all_donations()
    {
        $donations = Donation::factory()->count(5)->create();

        Livewire::test(ListDonations::class)
            ->assertCanSeeTableRecords($donations);
    }

    /** @test */
    public function can_view_one_time_donation()
    {
        $donation = Donation::factory()->create(['type' => 'one-time']);

        Livewire::test(ViewDonation::class, ['record' => $donation->id])
            ->assertSuccessful();
    }
}
