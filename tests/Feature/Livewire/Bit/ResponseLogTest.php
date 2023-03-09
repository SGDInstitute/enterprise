<?php

namespace Tests\Feature\Livewire\Bit;

use App\Http\Livewire\Bit\ResponseLog;
use App\Models\Form;
use App\Models\Response;
use App\Models\User;
use App\Notifications\WorkshopStatusChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class ResponseLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_all_activity_on_response(): void
    {
        $response = Response::factory()->create();
        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test(ResponseLog::class, ['response' => $response])
            ->assertSee('created');
    }

    /** @test */
    public function can_add_comment(): void
    {
        $form = Form::factory()->preset('workshop')->create();
        $response = Response::factory()->for($form)->create();
        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test(ResponseLog::class, ['response' => $response])
            ->set('comment', 'I have updated the description')
            ->call('save')
            ->assertEmitted('refresh')
            ->assertSet('comment', '');
    }

    /** @test */
    public function internal_comments_do_not_send_emails_to_creators(): void
    {
        Notification::fake();

        $form = Form::factory()->preset('workshop')->create();
        $response = Response::factory()->for($form)->create();

        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test(ResponseLog::class, ['response' => $response])
            ->set('comment', 'This is crap')
            ->set('internal', true)
            ->call('save');

        Notification::assertNothingSent();
    }

    /** @test */
    public function external_comments_do_send_emails_to_creators(): void
    {
        Notification::fake();

        $form = Form::factory()->preset('workshop')->create();
        $response = Response::factory()->for($form)->create();
        $userA = User::factory()->create();
        $response->collaborators()->sync([$userA->id]);

        $reviewer = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($reviewer)
            ->test(ResponseLog::class, ['response' => $response])
            ->set('comment', 'This is awesome')
            ->set('internal', false)
            ->call('save');

        Notification::assertSentTo([$userA], WorkshopStatusChanged::class);
    }

    /** @test */
    public function internal_comments_are_not_seen_by_creators(): void
    {
        $form = Form::factory()->preset('workshop')->create();
        $user = User::factory()->create();
        $response = Response::factory()->for($form)->for($user)->create();
        activity()->performedOn($response)->withProperties(['comment' => 'This is crap', 'internal' => true])->log('commented');

        Livewire::actingAs($user)
            ->test(ResponseLog::class, ['response' => $response])
            ->assertDontSee('This is crap');
    }
}
