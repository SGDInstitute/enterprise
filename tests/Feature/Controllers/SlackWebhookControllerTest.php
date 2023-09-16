<?php

namespace Tests\Feature\Controllers;

use App\Models\Invitation;
use App\Models\Post;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\InvitationAccepted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SlackWebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_approve_post_via_slack(): void
    {
        $post = Post::factory()->create();
        $user = User::factory()->admin()->create(['email' => 'andy@sgdinstitute.org']);

        $this->post('/slack/webhook', [
            // dumped response from 2023-09-15
            'payload' => '{"type":"block_actions","user":{"id":"U0V9QGVC7","username":"andy","name":"andy","team_id":"T0V9EN9LL"},"api_app_id":"A05S6NUSW6B","token":"qCVfEVKz68V51aghjR7Rk3qm","container":{"type":"message","message_ts":"1694820267.202159","channel_id":"C05TA89QL3A","is_ephemeral":false},"trigger_id":"5890877001607.29320757700.e8c0e661319d1837470ec16c996367de","team":{"id":"T0V9EN9LL","domain":"sgdinstitute"},"enterprise":null,"is_enterprise_install":false,"channel":{"id":"C05TA89QL3A","name":"mblgtacc-posts"},"message":{"bot_id":"B05SEKS06JJ","type":"message","text":"New MBLGTACC 2023 Post User Andy Newhouse (they\\/them) HIhi [] &lt;p&gt;Post&lt;\\/p&gt; Approve button Deny button","user":"U05SM96N1M0","ts":"1694820267.202159","app_id":"A05S6NUSW6B","blocks":[{"type":"header","block_id":"+C50","text":{"type":"plain_text","text":"New MBLGTACC 2023 Post","emoji":true}},{"type":"context","block_id":"\\/C9w=","elements":[{"type":"plain_text","text":"User Andy Newhouse (they\\/them)","emoji":true}]},{"type":"section","block_id":"3dy","fields":[{"type":"plain_text","text":"HIhi","emoji":true},{"type":"plain_text","text":"[]","emoji":true}]},{"type":"section","block_id":"zTG","text":{"type":"plain_text","text":"&lt;p&gt;Post&lt;\\/p&gt;","emoji":true}},{"type":"actions","block_id":"0Bm","elements":[{"type":"button","action_id":"approve_post","text":{"type":"plain_text","text":"Approve","emoji":true},"style":"primary","value":"' . $post->id . '"},{"type":"button","action_id":"deny_post","text":{"type":"plain_text","text":"Deny","emoji":true},"style":"danger","value":"' . $post->id . '"}]}],"team":"T0V9EN9LL"},"state":{"values":{}},"response_url":"https:\\/\\/hooks.slack.com\\/actions\\/T0V9EN9LL\\/5928406373072\\/j1kWuZ3x7r6wKJqWh9d209tE","actions":[{"action_id":"approve_post","block_id":"0Bm","text":{"type":"plain_text","text":"Approve","emoji":true},"value":"' . $post->id . '","style":"primary","type":"button","action_ts":"1694820270.026280"}]}',
        ]);

        $this->assertNotNull($post->fresh()->approved_at);
        $this->assertEquals($user->id, $post->fresh()->approved_by);
    }
}
