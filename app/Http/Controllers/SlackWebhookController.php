<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SlackWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->get('payload'));

        $slackUser = $payload->user;
        $user = User::firstWhere('email', $slackUser->username . '@sgdinstitute.org');
        // handle if user is null


        // find post
        $post = Post::findOrFail($payload->actions[0]->value);

        if ($payload->actions[0]->action_id === 'approve_post') {
            $post->approve($user);
            $action = 'approved';
        } else {
            $post->delete();
            $action = 'deleted';
        }

        Http::post($payload->response_url, [
            'replace_original' => true,
            'text' => "{$user->name} {$action} \"{$post->title}\" from {$post->user->formattedName}"
        ]);
    }
}
