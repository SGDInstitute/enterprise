<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Models\Event;
use App\Imports\ActivitiesImport;
use App\Imports\ContentImport;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventsContentController
 */
class EventsContentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $event = Event::factory()->create(['title' => 'MBLGTACC 2020', 'slug' => 'mblgtacc-2020']);

        Excel::import(new ContentImport, public_path('documents/content.xlsx'));

        Passport::actingAs(User::factory()->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/content");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'type',
                    'title',
                    'content',
                ],
            ],
        ]);

        $this->assertCount(3, $response->decodeResponseJson()['data']);
        $this->assertLessThan(3, count(DB::getQueryLog()));
    }

    /** @test */
    public function type_filter_returns_an_ok_response()
    {
        $event = Event::factory()->create(['title' => 'MBLGTACC 2020', 'slug' => 'mblgtacc-2020']);

        Excel::import(new ContentImport, public_path('documents/content.xlsx'));

        Passport::actingAs(User::factory()->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/content?type=faq");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'type',
                    'title',
                    'content',
                ],
            ],
        ]);

        $this->assertCount(2, $response->decodeResponseJson()['data']);
        $this->assertLessThan(3, count(DB::getQueryLog()));
    }
}
