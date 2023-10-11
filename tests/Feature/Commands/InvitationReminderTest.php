<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\InvitationReminder;
use App\Models\Invitation;
use App\Notifications\AcceptInviteReminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class InvitationReminderTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_send_reminders_of_pending_invitations()
    {
        Notification::fake();

        Invitation::factory()->count(5)->create(['updated_at' => now()->subWeeks(2)]);

        $this->artisan(InvitationReminder::class);

        Notification::assertSentTimes(AcceptInviteReminder::class, 5);
    }

    #[Test]
    public function does_not_send_notification_to_invitations_less_than_a_week_old()
    {
        Notification::fake();

        Invitation::factory()->create(['updated_at' => now()->subDay(7)]);
        Invitation::factory()->create(['updated_at' => now()->subDay(6)]);
        Invitation::factory()->create();

        $this->artisan(InvitationReminder::class);

        Notification::assertSentTimes(AcceptInviteReminder::class, 1);
    }

    #[Test]
    public function touch_invitation_so_does_not_get_sent_more_than_once_a_week()
    {
        Notification::fake();

        $invitation = Invitation::factory()->create(['updated_at' => now()->subWeek()]);

        $this->artisan(InvitationReminder::class);
        $this->artisan(InvitationReminder::class);

        $this->assertEquals(now()->toDateTimeString(), $invitation->fresh()->updated_at->toDateTimeString());

        Notification::assertSentTimes(AcceptInviteReminder::class, 1);
    }
}
