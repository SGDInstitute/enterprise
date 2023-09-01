<?php

namespace Tests\Feature\Filament\Resources\FormResource\ReplationManagers;

use App\Filament\Resources\FormResource\RelationManagers\ResponsesRelationManager;
use App\Models\Form;
use App\Models\Response;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ResponsesRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    // Can't test yet, Need to figure out better way to handle custom columns
    /** @test */
    public function can_bulk_change_status()
    {
        $this->markTestSkipped();
        $user = User::factory()->create();
        $form = Form::factory()->create(['form' => [
            ['data' => ['id' => 'timeline-information', 'content' => '<h2>Application Timeline</h2>'], 'type' => 'content'],
            ['data' => ['id' => 'name', 'type' => 'text', 'question' => 'Name of Workshop'], 'type' => 'question'],
        ]]);
        $acceptedProposals = Response::factory()->for($form)->count(5)->create(['answers' => ['name' => 'Hello world', 'status' => 'submitted']]);
        $deniedProposals = Response::factory()->for($form)->count(5)->create(['answers' => ['name' => 'Foo Bar'], 'status' => 'submitted']);

        Livewire::test(ResponsesRelationManager::class, ['ownerRecord' => $form])
            ->assertCanSeeTableRecords($acceptedProposals)
            ->assertCanSeeTableRecords($deniedProposals)
            ->callTableBulkAction('change_status', $acceptedProposals, ['status' => 'accepted']);
    }
}
