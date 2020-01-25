<?php

namespace Tests\Feature\Http\Controllers\Api\Gemini;

use App\Event;
use App\Form;
use App\Schedule;
use App\User;
use App\Imports\ActivitiesImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\Gemini\EvaluationsResponsesController
 */
class EvaluationsResponsesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_an_ok_response()
    {
        $event = factory(Event::class)->create(['title' => 'MBLGTACC', 'slug' => 'mblgtacc']);

        $friday = factory(Form::class)->create([
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

        Passport::actingAs(factory(User::class)->create());

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->postJson("api/gemini/evaluations/{$friday->id}/responses", [
            'hello-world' => 'Foo Bar',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'form',
                'response',
                'email',
            ]
        ]);

        $this->assertLessThan(5, count(DB::getQueryLog()));
    }
}
