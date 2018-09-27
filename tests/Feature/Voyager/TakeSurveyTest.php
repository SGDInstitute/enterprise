<?php

namespace Tests\Feature;

use App\Form;
use App\Survey;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TakeSurveyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_take_survey()
    {
        $form = factory(Form::class)->create([
            'form' => [
                [
                    "id" => "hello-world",
                    "question" => "Hello world.",
                     "type" => "textarea",
                    "rules" => "required",
                ]
            ],
        ]);

        $response = $this->withoutExceptionHandling()
            ->json("POST", "/forms/{$form->id}/responses", [
                "hello-world" => "Foo Bar",
            ]);

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas('responses', [
            'form_id' => $form->id,
            'responses' => '{"hello-world":"Foo Bar"}',
        ]);
    }

    /** @test */
    function required_fields_in_survey_form_are_required()
    {
        $form = factory(Form::class)->create([
            'form' => [
                [
                    "id" => "hello-world",
                    "question" => "Hello world.",
                    "type" => "textarea",
                    "rules" => "required",
                ]
            ],
        ]);

        $response = $this->json("POST", "/forms/{$form->id}/responses", []);
        $response->assertJsonValidationErrors('hello-world');
    }
}
