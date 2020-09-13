<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Event;
use App\Form;
use App\Imports\ActivitiesImport;
use App\Schedule;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EventsEvaluationsController
 */
class EventsEvaluationsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $event = Event::factory()->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);

        $friday = Form::factory()->create([
            'name' => 'Friday Mini-Survey',
            'type' => 'evaluation',
            'event_id' => $event->id,
            'form' => [
                [
                    'id' => 'hello-world',
                    'question' => 'Hello world.',
                    'type' => 'textarea',
                    'rules' => 'required',
                ],
            ],
        ]);
        $saturday = Form::factory()->create([
            'name' => 'Saturday Mini-Survey',
            'type' => 'evaluation',
            'event_id' => $event->id,
            'form' => [
                [
                    'id' => 'hello-world',
                    'question' => 'Hello world.',
                    'type' => 'textarea',
                    'rules' => 'required',
                ],
            ],
        ]);
        $sunday = Form::factory()->create([
            'name' => 'Sunday Mini-Survey',
            'type' => 'survey',
            'event_id' => $event->id,
            'form' => [
                [
                    'id' => 'hello-world',
                    'question' => 'Hello world.',
                    'type' => 'textarea',
                    'rules' => 'required',
                ],
            ],
        ]);

        Passport::actingAs(User::factory()->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->getJson("api/gemini/events/{$event->id}/evaluations");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'slug',
                    'start',
                    'end',
                    'form',
                ],
            ],
        ]);

        $this->assertCount(2, $response->decodeResponseJson()['data']);
        $this->assertLessThan(10, count(DB::getQueryLog()));
    }
}
