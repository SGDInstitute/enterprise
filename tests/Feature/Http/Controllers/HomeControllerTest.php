<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 */
class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function changelog_returns_an_ok_response()
    {
        $response = $this->get('changelog');

        $response->assertOk();
    }

    /** @test */
    public function index_returns_an_ok_response()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertOk();
    }
}
