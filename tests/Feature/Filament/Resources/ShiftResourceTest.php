<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\ShiftResource;
use App\Filament\Resources\ShiftResource\Pages\CreateShift;
use App\Filament\Resources\ShiftResource\Pages\ListShifts;
use App\Models\Event;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ShiftResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function happy_path_http_check_shifts_index(): void
    {
        $user = User::factory()->admin()->create();
        Shift::factory()->count(2)->create();

        $this->actingAs($user)
            ->get(ShiftResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    public function happy_path_http_check_shifts_create()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(ShiftResource::getUrl('create'))
            ->assertOk();
    }

    #[Test]
    public function happy_path_http_check_shifts_edit()
    {
        $user = User::factory()->admin()->create();
        $shift = Shift::factory()->create();

        $this->actingAs($user)
            ->get(ShiftResource::getUrl('edit', ['record' => $shift]))
            ->assertOk();
    }

    #[Test]
    public function list_shifts_has_records()
    {
        $shifts = Shift::factory()->count(2)->create();

        Livewire::test(ListShifts::class)
            ->assertCanSeeTableRecords($shifts);
    }

    #[Test]
    public function can_create_shift()
    {
        $event = Event::factory()->create();

        Livewire::test(CreateShift::class)
            ->fillForm([
                'event_id' => $event->id,
                'name' => 'Registration',
                'slots' => 2,
                'start' => now()->addHour(),
                'end' => now()->addHours(3),
            ])
            ->assertFormSet([
                'timezone' => $event->timezone,
            ]);
    }
}
