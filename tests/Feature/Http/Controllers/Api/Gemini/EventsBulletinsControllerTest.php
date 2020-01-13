<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Bulletin;
use App\Event;
use App\Schedule;
use App\User;
use App\Imports\ActivititesImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventsBulletinsController
 */
class EventBulletinsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        $maps = factory(Bulletin::class)->create(['event_id' => $event->id, 'content' => 'Get to know MBLGTACC']);
        $intro = factory(Bulletin::class)->create(['event_id' => $event->id, 'content' => 'Hello world']);

        Passport::actingAs(factory(User::class)->create());

        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/bulletins");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'content',
                    'links',
                    'image',
                ]
            ]
        ]);
    }
}
