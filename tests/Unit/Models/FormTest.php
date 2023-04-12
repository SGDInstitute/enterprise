<?php

namespace Tests\Unit\Models;

use App\Models\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_validation_attributes(): void
    {
        $form = Form::factory()->preset('new-workshop')->create([
            'start' => now()->subDay(),
            'end' => now()->addDays(4),
        ]);

        $this->assertEquals([
            'answers.name' => 'name',
            'answers.description' => 'description',
            'answers.session' => 'session',
            'answers.format' => 'format',
            'answers.outline-method' => 'outline method',
            'answers.outline-method-option-video' => 'outline method option video',
            'answers.outline-method-option-text' => 'outline method option text',
            'answers.track-first-choice' => 'track first choice',
            'answers.track-second-choice' => 'track second choice',
            'answers.experience' => 'experience',
            'answers.other' => 'other',
        ], $form->validationAttributes);
    }
}
