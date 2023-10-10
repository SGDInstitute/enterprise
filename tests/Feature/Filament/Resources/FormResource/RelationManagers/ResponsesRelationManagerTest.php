<?php

namespace Tests\Feature\Filament\Resources\FormResource\RelationManagers;

use App\Actions\GenerateCompedOrder;
use App\Filament\Resources\FormResource\Pages\ViewForm;
use App\Filament\Resources\FormResource\RelationManagers\ResponsesRelationManager;
use App\Models\Event;
use App\Models\Form;
use App\Models\Order;
use App\Models\Response;
use App\Models\TicketType;
use App\Models\User;
use App\Notifications\AcceptInviteReminder;
use App\Notifications\OrderCreatedForPresentation;
use App\Notifications\WorkshopCanceled;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ResponsesRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_render_responses_for_form()
    {
        $schema = json_decode(file_get_contents(base_path('tests/Feature/Filament/Resources/FormResource/RelationManagers/proposal-form.json')), true);
        $form = Form::factory()->create(['form' => $schema]);
        $responses = Response::factory()->for($form)->count(5)->create(['answers' => ['name' => 'Hello world', 'format' => 'presentation', 'session' => ['breakout-1'], 'track-first-choice' => 'rural', 'track-second-choice' => 'rural']]);

        Livewire::test(ResponsesRelationManager::class, ['ownerRecord' => $form, 'pageClass' => ViewForm::class])
            ->assertSuccessful()
            ->assertCanSeeTableRecords($responses);
    }

    #[Test]
    public function can_make_orders_in_bulk()
    {
        Notification::fake();

        $event = Event::factory()->has(TicketType::factory()->withPrice()->count(2))->create();
        $schema = json_decode(file_get_contents(base_path('tests/Feature/Filament/Resources/FormResource/RelationManagers/proposal-form.json')), true);
        $form = Form::factory()->for($event)->create(['form' => $schema]);
        $proposals = Response::factory()->for($form)
            ->count(2)
            ->state(new Sequence(
                ['status' => 'scheduled'],
                ['status' => 'confirmed'],
            ))
            ->has(User::factory()->count(2), 'collaborators')
            ->create(['answers' => ['name' => 'Hello world', 'format' => 'presentation', 'session' => ['breakout-1'], 'track-first-choice' => 'rural', 'track-second-choice' => 'rural']]);

        Livewire::test(ResponsesRelationManager::class, ['ownerRecord' => $form, 'pageClass' => ViewForm::class])
            ->callTableBulkAction('create_orders', $proposals)
            ->assertHasNoTableActionErrors()
            ->assertNotified();

        $orders = Order::all();
        $this->assertCount(4, $orders);
        $orders->each(fn ($order) => $this->assertTrue($order->isPaid()));

        Notification::assertSentTimes(OrderCreatedForPresentation::class, 4);
    }

    #[Test]
    public function making_orders_in_bulk_filters_out_responses_with_incorrect_status()
    {
        Notification::fake();

        $event = Event::factory()->has(TicketType::factory()->withPrice()->count(2))->create();
        $schema = json_decode(file_get_contents(base_path('tests/Feature/Filament/Resources/FormResource/RelationManagers/proposal-form.json')), true);
        $form = Form::factory()->for($event)->create(['form' => $schema]);
        $responses = Response::factory()->for($form)
            ->count(5)
            ->state(new Sequence(
                ['status' => 'work-in-progress'],
                ['status' => 'rejected'],
                ['status' => 'canceled'],
            ))
            ->has(User::factory()->count(2), 'collaborators')
            ->create(['answers' => ['name' => 'Hello world', 'format' => 'presentation', 'session' => ['breakout-1'], 'track-first-choice' => 'rural', 'track-second-choice' => 'rural']]);
        [$scheduled, $confirmed] = Response::factory()->for($form)
            ->count(2)
            ->state(new Sequence(
                ['status' => 'scheduled'],
                ['status' => 'confirmed'],
            ))
            ->has(User::factory()->count(2), 'collaborators')
            ->create(['answers' => ['name' => 'Hello world', 'format' => 'presentation', 'session' => ['breakout-1'], 'track-first-choice' => 'rural', 'track-second-choice' => 'rural']]);

        Livewire::test(ResponsesRelationManager::class, ['ownerRecord' => $form, 'pageClass' => ViewForm::class])
            ->callTableBulkAction('create_orders', [...$responses, $scheduled, $confirmed])
            ->assertHasNoTableActionErrors();

        $orders = Order::all();
        $this->assertCount(4, $orders);
        $orders->each(fn ($order) => $this->assertTrue($order->isPaid()));

        Notification::assertSentTimes(OrderCreatedForPresentation::class, 4);
    }

    #[Test]
    public function making_orders_in_bulk_sends_reminder_to_invites()
    {
        Notification::fake();

        $event = Event::factory()->has(TicketType::factory()->withPrice()->count(2))->create();
        $schema = json_decode(file_get_contents(base_path('tests/Feature/Filament/Resources/FormResource/RelationManagers/proposal-form.json')), true);
        $form = Form::factory()->for($event)->create(['form' => $schema]);
        $proposal = Response::factory()->for($form)
            ->create(['status' => 'scheduled', 'answers' => ['name' => 'Hello world', 'format' => 'presentation', 'session' => ['breakout-1'], 'track-first-choice' => 'rural', 'track-second-choice' => 'rural']]);
        $proposal->invite('adora@eternia.gov', $proposal->user);

        Livewire::test(ResponsesRelationManager::class, ['ownerRecord' => $form, 'pageClass' => ViewForm::class])
            ->callTableBulkAction('create_orders', [$proposal])
            ->assertHasNoTableActionErrors();

        $this->assertEmpty(Order::all());
        Notification::assertSentOnDemand(AcceptInviteReminder::class);
    }

    #[Test]
    public function making_orders_in_bulk_will_ignore_users_with_existing_comped_tickets()
    {
        Notification::fake();

        $event = Event::factory()->has(TicketType::factory()->withPrice()->count(2))->create();
        $schema = json_decode(file_get_contents(base_path('tests/Feature/Filament/Resources/FormResource/RelationManagers/proposal-form.json')), true);
        $form = Form::factory()->for($event)->create(['form' => $schema]);
        $user = User::factory()->create();
        [$proposalA, $proposalB] = Response::factory()->for($form)
            ->count(2)
            ->withCollaborator($user)
            ->create(['status' => 'confirmed', 'answers' => ['name' => 'Hello world', 'format' => 'presentation', 'session' => ['breakout-1'], 'track-first-choice' => 'rural', 'track-second-choice' => 'rural']]);

        (new GenerateCompedOrder)->presenter($event, $proposalA, $user);

        $this->assertTrue($user->fresh()->hasCompedTicketFor($event));

        Livewire::test(ResponsesRelationManager::class, ['ownerRecord' => $form, 'pageClass' => ViewForm::class])
            ->callTableBulkAction('create_orders', [$proposalA, $proposalB])
            ->assertHasNoTableActionErrors();

        $this->assertCount(1, $user->orders);
    }

    #[Test]
    public function when_canceling_single_presentation_cancel_orders()
    {
        Notification::fake();

        $event = Event::factory()->has(TicketType::factory()->withPrice()->count(2))->create();
        $schema = json_decode(file_get_contents(base_path('tests/Feature/Filament/Resources/FormResource/RelationManagers/proposal-form.json')), true);
        $form = Form::factory()->for($event)->create(['form' => $schema]);
        $collaboratorA = User::factory()->create();
        $collaboratorB = User::factory()->create();
        $proposal = Response::factory()->for($form)
            ->withCollaborator($collaboratorA)
            ->withCollaborator($collaboratorB)
            ->create(['status' => 'scheduled', 'answers' => ['name' => 'Hello world', 'format' => 'presentation', 'session' => ['breakout-1'], 'track-first-choice' => 'rural', 'track-second-choice' => 'rural']]);

        $proposal->invite('adora@eternia.gov', $collaboratorA);
        (new GenerateCompedOrder)->presenter($event, $proposal, $collaboratorA);
        (new GenerateCompedOrder)->presenter($event, $proposal, $collaboratorB);

        Livewire::test(ResponsesRelationManager::class, ['ownerRecord' => $form, 'pageClass' => ViewForm::class])
            ->callTableAction('change_status', $proposal, data: [
                'status' => 'canceled',
            ])
            ->assertHasNoTableActionErrors();

        $this->assertEquals('canceled', $proposal->fresh()->status);
        $this->assertEmpty($proposal->fresh()->invitations);
        $this->assertFalse($collaboratorA->fresh()->hasCompedTicketFor($event));
        $this->assertFalse($collaboratorB->fresh()->hasCompedTicketFor($event));

        Notification::assertSentTo($collaboratorA, WorkshopCanceled::class);
        Notification::assertSentTo($collaboratorB, WorkshopCanceled::class);
    }
}
