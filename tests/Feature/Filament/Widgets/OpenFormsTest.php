<?php

namespace Tests\Feature\Filament\Widgets;

use App\Filament\Widgets\OpenForms as WidgetsOpenForms;
use App\Models\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OpenFormsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_current_forms()
    {
        $future = Form::factory()->future()->create();
        $current = Form::factory()->current()->create();
        $past = Form::factory()->past()->create();

        Livewire::test(WidgetsOpenForms::class)
            ->assertCanSeeTableRecords([$current])
            ->assertCanNotSeeTableRecords([$future, $past]);
    }
}
