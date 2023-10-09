<?php

namespace Tests\Feature\Filament\Resources\FormResource\RelationManagers;

use App\Filament\Resources\FormResource\Pages\ViewForm;
use App\Filament\Resources\FormResource\RelationManagers\ResponsesRelationManager;
use App\Models\Form;
use App\Models\Order;
use App\Models\Response;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $schema = json_decode(file_get_contents(base_path('tests/Feature/Filament/Resources/FormResource/RelationManagers/proposal-form.json')), true);
        $form = Form::factory()->create(['form' => $schema]);
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
            ->callTableBulkAction('create_orders', [...$responses, $scheduled, $confirmed]);

        $this->assertCount(4, Order::all());
    }
}
