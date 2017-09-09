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
     * @param $message
     */
    public function __construct($invitee, $coordinator, $ticket, $message = null)
    {
        $this->user = $invitee;
        $this->coordinator = $coordinator;
        $this->ticket = $ticket;
        $this->note = $message;
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
