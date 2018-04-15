<?php

namespace Tests\Unit\Billing;

use Facades\App\Billing\Address;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /** @test */
    public function can_format_address_from_stripe()
    {
        $address = Address::format((object) [
            'address_city' => 'Downers Grove',
            'address_country' => 'United States',
            'address_line1' => '2113 Midhurst rd',
            'address_line1_check' => 'pass',
            'address_line2' => null,
            'address_state' => 'IL',
            'address_zip' => '60516',
            'address_zip_check' => 'pass',
        ]);

        $this->assertEquals('2113 Midhurst rd<br>Downers Grove, IL<br>60516', $address);

        $address = Address::format((object) [
            'address_city' => 'Chicago',
            'address_country' => 'United States',
            'address_line1' => '6031 N Paulina',
            'address_line1_check' => 'pass',
            'address_line2' => 'Apt 3A',
            'address_state' => 'IL',
            'address_zip' => '60660',
            'address_zip_check' => 'pass',
        ]);

        $this->assertEquals('6031 N Paulina Apt 3A<br>Chicago, IL<br>60660', $address);
    }
}
