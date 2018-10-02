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

    public $coordinator;

    public $ticket;

    public $note;

    public $url;

    /**
     * Create a new message instance.
     *
     * @param $invitee
     * @param $coordinator
     * @param $ticket
     * @param null $note
     */
    public function __construct($invitee, $coordinator, $ticket, $note = null)
    {
        $this->user = $invitee;
        $this->coordinator = $coordinator;
        $this->ticket = $ticket;
        $this->note = $note;
        $this->url = $this->generateUrl($invitee);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invite');
    }

    private function generateUrl($user)
    {
        $token = resolve(PasswordBrokerManager::class)->createToken($user);
        return url("/password/reset/{$token}");
    }
}
