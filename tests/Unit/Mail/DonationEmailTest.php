<?php

namespace Tests\Unit\Mail;

use App\Donation;
use App\Mail\DonationEmail;
use App\Receipt;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function email_contains_link_to_donation_page()
    {
        $donation = factory(Donation::class)->create();
        $donation->receipt()->save(factory(Receipt::class)->make());

        $email = (new DonationEmail($donation))->render();

        $this->assertContains('/donations/' . $donation->id, $email);
    }

    /** @test */
    function email_contains_amount()
    {
        $donation = factory(Donation::class)->create([
            'amount' => 3500
        ]);
        $donation->receipt()->save(factory(Receipt::class)->make());

        $email = (new DonationEmail($donation))->render();

        $this->assertContains('$35.00', $email);
    }
}
