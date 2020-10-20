<?php

namespace Tests\Unit\Mail;

use App\Models\Donation;
use App\Mail\DonationEmail;
use App\Models\Receipt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_contains_link_to_donation_page()
    {
        $donation = Donation::factory()->create();
        $donation->receipt()->save(Receipt::factory()->make());

        $email = (new DonationEmail($donation))->render();

        $this->assertStringContainsString('/donations/'.$donation->id, $email);
    }

    /** @test */
    public function email_contains_amount()
    {
        $donation = Donation::factory()->create([
            'amount' => 3500,
        ]);
        $donation->receipt()->save(Receipt::factory()->make());

        $email = (new DonationEmail($donation))->render();

        $this->assertStringContainsString('$35.00', $email);
    }
}
