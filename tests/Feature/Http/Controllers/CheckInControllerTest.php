<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CheckInController
 */
class CheckInControllerTest extends TestCase
{
    /** @test */
    public function invoke_returns_an_ok_response()
    {
        $response = $this->get('checkin');

        $response->assertOk();
    }
}
