<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Event;
use App\Schedule;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventsSchedulesController
 */
class EventSchedulesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $mblgtacc = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        factory(Schedule::class)->create(['event_id' => $mblgtacc->id, 'title' => 'Main Track']);
        factory(Schedule::class)->create(['event_id' => $mblgtacc->id, 'title' => 'Advisor Track']);
        $musicFest = factory(Event::class)->create(['title' => 'Music Fest', 'slug' => 'music-fest']);
        factory(Schedule::class)->create(['event_id' => $musicFest->id, 'title' => 'Festival']);

        Passport::actingAs(factory(User::class)->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$mblgtacc->id}/schedules");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'event',
                    'title',
                ],
            ],
        ]);

        $this->assertCount(2, $response->decodeResponseJson()['data']);
        $this->assertLessThan(5, count(DB::getQueryLog()));
    }

    /** @test */
    public function show_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        $mainSchedule = factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Main Track']);
        factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Advisor Track']);

        Passport::actingAs(factory(User::class)->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/schedules/{$mainSchedule->id}");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'event',
                'title',
            ],
        ]);

        $this->assertEquals('MBLGTACC', $response->decodeResponseJson()['data']['event']);
        $this->assertEquals('Main Track', $response->decodeResponseJson()['data']['title']);
        $this->assertLessThan(5, count(DB::getQueryLog()));
    }
}
