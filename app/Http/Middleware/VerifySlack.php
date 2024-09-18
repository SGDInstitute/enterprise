<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySlack
{
    /**
     * Validate a slack request
     * by the slack signing secret (not the token)
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.env') === 'testing') {
            return $next($request);
        }

        // define the version number
        $version = 'v0';

        // load the secret, you also can load it from env(YOUR_OWN_SLACK_SECRET)
        $secret = config('services.slack.signing_secret');

        // get the payload
        $body = $request->getContent();

        // get the timestamp
        // and compare with the local time, according to the slack official documents
        // the gap should under 5 minutes
        $timestamp = $request->header('X-Slack-Request-Timestamp');
        if (Carbon::now()->diffInMinutes(Carbon::createFromTimestamp($timestamp)) > 5) {
            throw new Exception('Invalid timstamp, too much gap');
        }

        // generate the string base
        $sig_basestring = "{$version}:{$timestamp}:{$body}";

        // generate the local sign
        $hash = hash_hmac('sha256', $sig_basestring, $secret);
        $local_signature = "{$version}={$hash}";

        // get the remote sign
        $remote_signature = $request->header('X-Slack-Signature');

        // check two signs, if not match, throw an error
        if ($remote_signature !== $local_signature) {
            throw new Exception('Invalid signature');
        }

        return $next($request);
    }
}
