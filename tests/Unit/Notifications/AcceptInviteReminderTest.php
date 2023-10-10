<?php

namespace Tests\Unit\Notifications;

use App\Models\Response;
use App\Models\User;
use App\Notifications\AcceptInviteReminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AcceptInviteReminderTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function when_invited_to_proposal_and_proposal_is_accepted_has_line_about_order()
    {
        $user = User::factory()->create();

        $response = Response::factory()->create(['status' => 'scheduled']);
        $invitation = $response->invite('adora@eternia.gov', $user);
        $notification = (new AcceptInviteReminder($invitation, $response))->toMail($user);

        $this->assertCount(2, $notification->introLines);

        $response = Response::factory()->create(['status' => 'work-in-progress']);
        $invitation = $response->invite('adora@eternia.gov', $user);
        $notification = (new AcceptInviteReminder($invitation, $response))->toMail($user);

        $this->assertCount(1, $notification->introLines);
    }
}
