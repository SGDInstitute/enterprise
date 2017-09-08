<?php

namespace App\Mail;

use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $host;

    public $url;

    /**
     * Create a new message instance.
     *
     * @param $invitee
     * @param $host
     */
    public function __construct($invitee, $host)
    {
        $this->user = $invitee;
        $this->host = $host;
        $this->url = $this->generateUrl($invitee);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invite');
    }

    private function generateUrl($user)
    {
        $token = resolve(PasswordBrokerManager::class)->createToken($user);
        return url("/password/reset/{$token}");
    }
}
