<?php

namespace Tests\Unit\Models;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class EventTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_get_reservation_ends_at(): void
    {
        $event = Event::factory()->create([
            'start' => now()->addDays(60),
            'settings' => ['reservation_length' => '45'],
        ]);

        $this->assertEquals(now()->addDays(45)->format('Y-m-d'), $event->reservationEndsAt->format('Y-m-d'));
    }

    #[Test]
    public function start_date_overrides_reservation_length_if_closer(): void
    {
        $event = Event::factory()->create([
            'start' => now()->addDays(15),
            'settings' => ['reservation_length' => '45'],
        ]);

        $this->assertEquals(now()->addDays(15)->format('Y-m-d'), $event->reservationEndsAt->format('Y-m-d'));
    }
}
