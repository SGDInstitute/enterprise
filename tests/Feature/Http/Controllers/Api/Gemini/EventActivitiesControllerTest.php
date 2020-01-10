<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Activity;
use App\Event;
use App\Imports\ActivititesImport;
use App\Schedule;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventActivitiesController
 */
class EventActivitiesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        $mainTrack = factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Main Track']);
        $advisorTrack = factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Advisor Track']);

        Excel::import(new ActivititesImport, public_path('documents/schedule.xlsx'));

        Passport::actingAs(factory(User::class)->create());

        $response = $this->withoutExceptionHandling()->getJson("api/gemini/event/{$event->id}/activities");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'schedule',
                    'title',
                    'speaker',
                    'description',
                    'type',
                    'location',
                    'start',
                    'end',
                ]
            ]
        ]);
    }

    /** @test */
    public function index_with_track_filter_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Main Track']);
        factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Advisor Track']);
        $event = factory(Event::class)->create(['title' => 'Music Fest', 'slug' => 'music-fest']);
        factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Festival']);

        Passport::actingAs(factory(User::class)->create());

        $response = $this->withoutExceptionHandling()->getJson('api/gemini/schedules?event=mblgtacc');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'event',
                    'title',
                ]
            ]
        ]);

        $this->assertCount(2, $response->decodeResponseJson()['data']);
    }

    /** @test */
    public function show_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        $mainSchedule = factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Main Track']);
        factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Advisor Track']);

        Passport::actingAs(factory(User::class)->create());

        $response = $this->withoutExceptionHandling()->getJson('api/gemini/schedules/' . $mainSchedule->id);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'event',
                'title',
            ]
        ]);

        $this->assertEquals('MBLGTACC', $response->decodeResponseJson()['data']['event']);
        $this->assertEquals('Main Track', $response->decodeResponseJson()['data']['title']);
    }
}
