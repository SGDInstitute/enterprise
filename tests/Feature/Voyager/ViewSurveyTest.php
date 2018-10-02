<?php

namespace Tests\Feature;

use App\Form;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewSurveyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_view_survey_by_slug()
    {
        $form = factory(Form::class)->create([
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
