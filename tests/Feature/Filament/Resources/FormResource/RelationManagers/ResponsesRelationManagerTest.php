<?php

namespace Tests\Feature\Filament\Resources\FormResource\RelationManagers;

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
            ->assertHasNoTableActionErrors();

        $orders = Order::all();
        $this->assertCount(4, $orders);
        $orders->each(fn ($order) => $this->assertTrue($order->isPaid()));

        Notification::assertSentTimes(OrderCreatedForPresentation::class, 4);
    }

    #[Test]
    public function making_orders_in_bulk_filters_out_responses_without_correct_status()
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
}
