<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Bulletin;
use App\Event;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventsBulletinsController
 */
class EventsBulletinsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        $maps = factory(Bulletin::class)->create(['event_id' => $event->id, 'content' => 'Get to know MBLGTACC']);
        $intro = factory(Bulletin::class)->create(['event_id' => $event->id, 'content' => 'Hello world']);

        Passport::actingAs(factory(User::class)->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/bulletins");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'content',
                    'links',
                    'image',
                ],
            ],
        ]);

        $this->assertLessThan(5, count(DB::getQueryLog()));
    }
}
