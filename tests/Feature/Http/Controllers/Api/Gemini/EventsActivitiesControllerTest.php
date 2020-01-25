<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Event;
use App\Schedule;
use App\User;
use App\Imports\ActivitiesImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventsActivitiesController
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

        Excel::import(new ActivitiesImport, public_path('documents/schedule.xlsx'));

        Passport::actingAs(factory(User::class)->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/activities");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'schedule',
                    'title',
                    'speakers' => [
                        '*' => [
                            'name', 'email', 'pronouns'
                        ]
                    ],
                    'description',
                    'type',
                    'location',
                    'start',
                    'end',
                ]
            ]
        ]);
        $this->assertLessThan(10, count(DB::getQueryLog()));
    }

    /** @test */
    public function group_by_date_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);
        $mainTrack = factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Main Track']);
        $advisorTrack = factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Advisor Track']);

        Excel::import(new ActivitiesImport, public_path('documents/schedule.xlsx'));

        Passport::actingAs(factory(User::class)->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/activities?groupBy=date");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '2020-02-14' => [
                    'data' => [
                        '*' => [
                            'id',
                            'schedule',
                            'title',
                            'speakers' => [
                                '*' => [
                                    'name', 'email', 'pronouns'
                                ]
                            ],
                            'description',
                            'type',
                            'location',
                            'start',
                            'end',
                        ]
                    ],
                    'date'
                ],
                '2020-02-15' => [
                    'data' => [
                        '*' => [
                            'id',
                            'schedule',
                            'title',
                            'speakers' => [
                                '*' => [
                                    'name', 'email', 'pronouns'
                                ]
                            ],
                            'description',
                            'type',
                            'location',
                            'start',
                            'end',
                        ]
                    ],
                    'date'
                ],
                '2020-02-16' => [
                    'data' => [
                        '*' => [
                            'id',
                            'schedule',
                            'title',
                            'speakers' => [
                                '*' => [
                                    'name', 'email', 'pronouns'
                                ]
                            ],
                            'description',
                            'type',
                            'location',
                            'start',
                            'end',
                        ]
                    ],
                    'date'
                ],
            ]
        ]);

        $this->assertLessThan(10, count(DB::getQueryLog()));
    }
}
