<?php

namespace Tests\Feature\Filament\Resources\ResponseResource\Pages;

use PHPUnit\Framework\Attributes\Test;
use App\Filament\Resources\ResponseResource\Pages\ReviewResponse;
use App\Models\Form;
use App\Models\Response;
use App\Models\RfpReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReviewResponseTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_view_details_of_response()
    {
        $form = Form::factory()->create(['form' => [
            ['data' => ['id' => 'timeline-information', 'content' => '<h2>Application Timeline</h2>'], 'type' => 'content'],
            ['data' => ['id' => 'name', 'type' => 'text', 'question' => 'Name of Workshop'], 'type' => 'question'],
        ]]);
        $proposal = Response::factory()->for($form)->create(['answers' => ['name' => 'Hello world']]);

        Livewire::test(ReviewResponse::class, ['record' => $proposal])
            ->assertSuccessful()
            ->assertDontSee('Application Timeline')
            ->assertSee('Name of Workshop')
            ->assertSee('Hello world');
    }

    #[Test]
    public function can_add_review()
    {
        // @todo update to action implementation
        $this->markTestSkipped();

        $user = User::factory()->create();
        $form = Form::factory()->create(['form' => [
            ['data' => ['id' => 'timeline-information', 'content' => '<h2>Application Timeline</h2>'], 'type' => 'content'],
            ['data' => ['id' => 'name', 'type' => 'text', 'question' => 'Name of Workshop'], 'type' => 'question'],
        ]]);
        $proposal = Response::factory()->for($form)->create(['answers' => ['name' => 'Hello world']]);

        Livewire::actingAs($user)
            ->test(ReviewResponse::class, ['record' => $proposal])
            ->fillForm([
                'alignment' => 1,
                'experience' => 1,
                'priority' => 1,
                'track' => 1,
                'notes' => 'Seems pretty bad, like it was automatically filled.',
            ])
            ->call('submit')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('rfp_reviews', [
            'user_id' => $user->id,
            'form_id' => $form->id,
            'response_id' => $proposal->id,
            'alignment' => 1,
            'experience' => 1,
            'priority' => 1,
            'track' => 1,
            'score' => 4,
            'notes' => 'Seems pretty bad, like it was automatically filled.',
        ]);
    }

    #[Test]
    public function can_edit_review()
    {
        // @todo update to action implementation
        $this->markTestSkipped();

        $user = User::factory()->create();
        $form = Form::factory()->create(['form' => [
            ['data' => ['id' => 'timeline-information', 'content' => '<h2>Application Timeline</h2>'], 'type' => 'content'],
            ['data' => ['id' => 'name', 'type' => 'text', 'question' => 'Name of Workshop'], 'type' => 'question'],
        ]]);
        $proposal = Response::factory()->for($form)->create(['answers' => ['name' => 'Hello world']]);
        $review = RfpReview::factory()->for($user)->for($form)->for($proposal)->create([
            'alignment' => 3,
            'experience' => 3,
            'priority' => 3,
            'track' => 3,
            'score' => 12,
            'notes' => 'Seems good',
        ]);

        Livewire::actingAs($user)
            ->test(ReviewResponse::class, ['record' => $proposal])
            ->assertFormSet([
                'alignment' => 3,
                'experience' => 3,
                'priority' => 3,
                'track' => 3,
                'notes' => 'Seems good',
            ])
            ->fillForm([
                'alignment' => 2,
                'experience' => 2,
                'priority' => 2,
                'track' => 2,
                'notes' => 'Seems pretty bad, like it was automatically filled.',
            ])
            ->call('submit');

        $review->refresh();
        $this->assertEquals(2, $review->alignment);
        $this->assertEquals(2, $review->experience);
        $this->assertEquals(2, $review->priority);
        $this->assertEquals(2, $review->track);
        $this->assertEquals(8, $review->score);
        $this->assertEquals('Seems pretty bad, like it was automatically filled.', $review->notes);
    }

    #[Test]
    public function cannot_review_your_own_proposal()
    {
        // @todo update to action implementation
        $this->markTestSkipped();

        $user = User::factory()->create();
        $collaborator = User::factory()->create();
        $form = Form::factory()->create(['form' => [
            ['data' => ['id' => 'timeline-information', 'content' => '<h2>Application Timeline</h2>'], 'type' => 'content'],
            ['data' => ['id' => 'name', 'type' => 'text', 'question' => 'Name of Workshop'], 'type' => 'question'],
        ]]);
        $proposal = Response::factory()->for($form)->for($user)->create(['answers' => ['name' => 'Hello world']]);

        $proposal->collaborators()->attach($collaborator);

        Livewire::actingAs($user)
            ->test(ReviewResponse::class, ['record' => $proposal])
            ->assertFormFieldIsDisabled('alignment')
            ->assertFormFieldIsDisabled('experience')
            ->assertFormFieldIsDisabled('priority')
            ->assertFormFieldIsDisabled('track')
            ->assertFormFieldIsDisabled('notes');

        Livewire::actingAs($collaborator)
            ->test(ReviewResponse::class, ['record' => $proposal])
            ->assertFormFieldIsDisabled('alignment')
            ->assertFormFieldIsDisabled('experience')
            ->assertFormFieldIsDisabled('priority')
            ->assertFormFieldIsDisabled('track')
            ->assertFormFieldIsDisabled('notes');
    }

    #[Test]
    public function cannot_review_a_work_in_progress()
    {
        // @todo update to action implementation
        $this->markTestSkipped();
        $user = User::factory()->create();
        $form = Form::factory()->create(['form' => [
            ['data' => ['id' => 'timeline-information', 'content' => '<h2>Application Timeline</h2>'], 'type' => 'content'],
            ['data' => ['id' => 'name', 'type' => 'text', 'question' => 'Name of Workshop'], 'type' => 'question'],
        ]]);
        $proposal = Response::factory()->for($form)->create(['status' => 'work-in-progress', 'answers' => ['name' => 'Hello world']]);

        Livewire::actingAs($user)
            ->test(ReviewResponse::class, ['record' => $proposal])
            ->assertFormFieldIsDisabled('alignment')
            ->assertFormFieldIsDisabled('experience')
            ->assertFormFieldIsDisabled('priority')
            ->assertFormFieldIsDisabled('track')
            ->assertFormFieldIsDisabled('notes');
    }
}
