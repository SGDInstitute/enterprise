<?php

namespace Tests\Feature\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ReportEventTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_report_edit()
    {
        $user = User::factory()->admin()->create();
        $event = Event::factory()->create();

        $this->actingAs($user)
            ->get(EventResource::getUrl('report', ['record' => $event]))
            ->assertOk();
    }
}
