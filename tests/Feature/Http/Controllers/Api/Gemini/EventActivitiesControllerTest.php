<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Event;
use App\Schedule;
use App\User;
use App\Imports\ActivititesImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
