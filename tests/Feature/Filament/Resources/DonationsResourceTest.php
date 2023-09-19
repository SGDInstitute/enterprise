<?php

namespace Tests\Feature\Filament\Resources;

use PHPUnit\Framework\Attributes\Test;
use App\Filament\Resources\DonationResource\Pages\ListDonations;
use App\Filament\Resources\DonationResource\Pages\ViewDonation;
use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DonationsResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_view_all_donations(): void
    {
        $donations = Donation::factory()->count(5)->create();

        Livewire::test(ListDonations::class)
            ->assertCanSeeTableRecords($donations);
    }

    #[Test]
    public function can_view_one_time_donation(): void
    {
        $donation = Donation::factory()->create(['type' => 'one-time']);

        Livewire::test(ViewDonation::class, ['record' => $donation->id])
            ->assertSuccessful();
    }
}
