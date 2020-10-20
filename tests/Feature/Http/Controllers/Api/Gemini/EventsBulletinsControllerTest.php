<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Models\Bulletin;
use App\Models\Event;
use App\Models\User;
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
        $event = Event::factory()->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        $maps = Bulletin::factory()->create(['event_id' => $event->id, 'content' => 'Get to know MBLGTACC']);
        $intro = Bulletin::factory()->create(['event_id' => $event->id, 'content' => 'Hello world']);

        Passport::actingAs(User::factory()->create());

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
