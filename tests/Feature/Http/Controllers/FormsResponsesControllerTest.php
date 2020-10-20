<?php

namespace Tests\Feature\Http\Controllers\Voyager;

use App\Models\Form;
use App\Survey;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FormsResponsesController
 */
class FormsResponsesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function can_take_survey()
    {
        $form = Form::factory()->create([
            'form' => [
                [
                    'id' => 'hello-world',
                    'question' => 'Hello world.',
                    'type' => 'textarea',
                    'rules' => 'required',
                ],
            ],
        ]);

        $response = $this->withoutExceptionHandling()
            ->json('POST', "/forms/{$form->id}/responses", [
                'hello-world' => 'Foo Bar',
            ]);

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas('responses', [
            'form_id' => $form->id,
            'responses' => '{"hello-world":"Foo Bar"}',
        ]);
    }

    /** @test */
    public function required_fields_in_survey_form_are_required()
    {
        $form = Form::factory()->create([
            'form' => [
                [
                    'id' => 'hello-world',
                    'question' => 'Hello world.',
                    'type' => 'textarea',
                    'rules' => 'required',
                ],
            ],
        ]);

        $response = $this->json('POST', "/forms/{$form->id}/responses", []);
        $response->assertJsonValidationErrors('hello-world');
    }

    /** @test */
    public function cannot_take_workshop_form_without_being_logged_in()
    {
        $form = Form::factory()->create([
            'type' => 'workshop',
            'form' => [
                [
                    'id' => 'hello-world',
                    'question' => 'Hello world.',
                    'type' => 'textarea',
                    'rules' => 'required',
                ],
            ],
        ]);

        $response = $this->withoutExceptionHandling()
            ->json('POST', "/forms/{$form->id}/responses", [
                'hello-world' => 'Foo Bar',
            ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function workshop_is_attached_to_user()
    {
        $user = User::factory()->create();
        $form = Form::factory()->create([
            'type' => 'workshop',
            'form' => [
                [
                    'id' => 'hello-world',
                    'question' => 'Hello world.',
                    'type' => 'textarea',
                    'rules' => 'required',
                ],
            ],
        ]);
        Passport::actingAs($user);

        $response = $this->actingAs($user)->withoutExceptionHandling()
            ->json('POST', "/forms/{$form->id}/responses", [
                'hello-world' => 'Foo Bar',
            ]);

        $response->assertStatus(200);

        $this->assertNotNull($user->responses->where('form_id', $form->id)->first());
    }

    /** @test */
    public function can_view_survey_by_slug()
    {
        $form = Form::factory()->create([
            'name' => 'Test Survey',
            'slug' => 'test-survey',
            'start' => Carbon::now()->subWeek(),
            'end' => Carbon::now()->addWeek(),
        ]);

        $response = $this->withoutExceptionHandling()->get("/forms/{$form->slug}");

        $response
            ->assertStatus(200)
            ->assertSee('Test Survey');
    }
}
