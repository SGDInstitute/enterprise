<?php

namespace Tests\Feature\Filament\Resources\FormResource\ReplationManagers;

use App\Filament\Resources\FormResource\Pages\ViewForm;
use App\Models\Form;
use App\Models\Response;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ViewFormTest extends TestCase
{
    use RefreshDatabase;

    // Can't test yet, Need to figure out better way to handle custom columns
    // /** @test */
    // public function can_notify_approved_proposals()
    // {
    //     $user = User::factory()->create();
    //     $form = Form::factory()->create(['form' => [
    //         ['data' => ['id' => 'timeline-information', 'content' => '<h2>Application Timeline</h2>'], 'type' => 'content'],
    //         ['data' => ['id' => 'name', 'type' => 'text', 'question' => 'Name of Workshop'], 'type' => 'question'],
    //     ]]);
    //     $proposal = Response::factory()->for($form)->for($user)->create(['answers' => ['name' => 'Hello world']]);

    //     Livewire::actingAs($user)
    //         ->test(ViewForm::class, ['record' => $form->id])
    //         ->callPageAction('notify_approved');
    // }
}
