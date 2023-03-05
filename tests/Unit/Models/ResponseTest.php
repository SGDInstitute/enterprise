<?php

namespace Tests\Unit\Models;

use App\Models\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_score_if_nothing_is_in_array(): void
    {
        $response = Response::factory()->make([
            'form_id' => 1,
            'user_id' => 1,
            'type' => 'review',
            'answers' => ['question-notes' => 'Just no', 'question-rubric' => '', 'question-tracks' => ''],
        ]);

        $this->assertEquals(0, $response->score);
    }
}
