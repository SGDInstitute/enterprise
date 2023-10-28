<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\CompleteTicketsReminder;
use App\Models\Event;
use App\Models\Order;
use App\Notifications\CompleteTicketsReminder as NotificationsCompleteTicketsReminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CompleteTicketsReminderTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_send_reminders_to_orders_with_incomplete_tickets()
    {
        Notification::fake();

        $event = Event::factory()->future()->create();
        Order::factory()->for($event)->hasTickets(2)->create();

        $this->artisan(CompleteTicketsReminder::class);

        Notification::assertSentTimes(NotificationsCompleteTicketsReminder::class, 1);
    }

    #[Test]
    public function reminders_are_not_sent_to_orders_of_past_events()
    {
        Notification::fake();

        $event = Event::factory()->create(['start' => now()->subDay()]);
        Order::factory()->for($event)->hasTickets(2)->create();

        $this->artisan(CompleteTicketsReminder::class);

        Notification::assertNothingSent(NotificationsCompleteTicketsReminder::class);
    }
}
