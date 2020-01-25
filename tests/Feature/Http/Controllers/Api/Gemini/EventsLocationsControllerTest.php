<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Event;
use App\User;
use App\Imports\FloorsImport;
use App\Imports\LocationsImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventsLocationsController
 */
class EventsLocationsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC 2020', 'slug' => 'mblgtacc-2020']);

        Excel::import(new LocationsImport, public_path('documents/locations.xlsx'));
        Excel::import(new FloorsImport, public_path('documents/floors.xlsx'));

        Passport::actingAs(factory(User::class)->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/locations");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'type',
                    'title',
                    'background',
                    'description',
                    'coordinates' => ['latitude', 'longitude'],
                    'floors' => [
                        '*' => [
                            'floor_plan',
                            'level',
                            'rooms' => [
                                '*' => [
                                    'number'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertLessThan(5, count(DB::getQueryLog()));
    }
}
