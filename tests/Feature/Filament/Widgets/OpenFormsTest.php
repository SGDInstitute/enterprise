<?php

namespace Tests\Feature\Filament\Widgets;

use App\Filament\Widgets\OpenForms as WidgetsOpenForms;
use App\Models\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class OpenFormsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_list_current_forms(): void
    {
        $future = Form::factory()->future()->create();
        $current = Form::factory()->current()->create();
        $past = Form::factory()->past()->create();

        Livewire::test(WidgetsOpenForms::class)
            ->assertCanSeeTableRecords([$current])
            ->assertCanNotSeeTableRecords([$future, $past]);
    }
}
