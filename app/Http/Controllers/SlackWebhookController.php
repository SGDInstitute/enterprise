<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SlackWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->get('payload'));

        $email = $payload->user->username . '@sgdinstitute.org';
        $user = User::firstWhere('email', $email);

        abort_if($user === null, 404, "User not found with email: {$email}");

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
            'text' => "{$user->name} {$action} \"{$post->title}\" from {$post->user->formattedName}",
        ]);
    }
}
