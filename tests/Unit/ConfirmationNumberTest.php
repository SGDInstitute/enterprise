<?php

namespace Tests\Unit;

use Facades\App\ConfirmationNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfirmationNumberTest extends TestCase
{
    /** @test */
    public function confirmation_number_is_sixteen_characters_long()
    {
        $confirmationNumber = ConfirmationNumber::generate();

        $this->assertEquals(16, strlen($confirmationNumber));
    }

    /** @test */
    public function confirmation_numbers_can_only_contain_uppercase_letters_and_numbers()
    {
        $confirmationNumber = ConfirmationNumber::generate();

        $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $confirmationNumber);
    }

    /** @test */
    public function confirmation_numbers_cannot_contain_ambiguous_characters()
    {
        $confirmationNumber = ConfirmationNumber::generate();

        $this->assertFalse(strpos($confirmationNumber, 'I'));
        $this->assertFalse(strpos($confirmationNumber, '1'));
        $this->assertFalse(strpos($confirmationNumber, 'O'));
        $this->assertFalse(strpos($confirmationNumber, '0'));
    }

    /** @test */
    public function confirmation_numbers_must_be_unique()
    {
        $confirmationNumbers = collect(range(1, 50))->map(function () {
            return ConfirmationNumber::generate();
        });

        $this->assertCount(50, $confirmationNumbers->unique());
    }
}
