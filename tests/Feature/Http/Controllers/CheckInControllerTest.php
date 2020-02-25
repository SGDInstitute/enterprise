<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CheckInController
 */
class CheckInControllerTest extends TestCase
{
    /** @test */
    public function invoke_returns_an_ok_response()
    {
        $response = $this->withoutExceptionHandling()->get('checkin');

        $response->assertOk();
    }
}
