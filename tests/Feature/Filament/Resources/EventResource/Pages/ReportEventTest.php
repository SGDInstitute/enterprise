<?php

namespace Tests\Feature\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ReportEventTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function happy_path_http_check()
    {
        $user = User::factory()->admin()->create();
        $event = Event::factory()->create();

        $this->actingAs($user)
            ->get(EventResource::getUrl('report', ['record' => $event]))
            ->assertOk();
    }
}
