<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\PaymentReminder;
use App\Models\Event;
use App\Models\Order;
use App\Notifications\PaymentReminder as NotificationsPaymentReminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PaymentReminderTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_send_reminders_to_unpaid_orders()
    {
        Notification::fake();

        $event = Event::factory()->future()->create();
        Order::factory()->for($event)->paid()->create();
        Order::factory()->for($event)->create();

        $this->artisan(PaymentReminder::class);

        Notification::assertSentTimes(NotificationsPaymentReminder::class, 1);
    }

    #[Test]
    public function reminders_are_not_sent_to_unpaid_of_past_events()
    {
        Notification::fake();

        $event = Event::factory()->create(['start' => now()->subDay()]);
        Order::factory()->for($event)->create();

        $this->artisan(PaymentReminder::class);

        Notification::assertNothingSent(NotificationsPaymentReminder::class);
    }
}
