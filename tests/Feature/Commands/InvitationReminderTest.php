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
}
