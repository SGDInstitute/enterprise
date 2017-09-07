<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MagicLoginEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $url;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $data
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->url = url("/login/magiclink/{$user->token->token}") . '?' . http_build_query([
                'email' => array_get($data, 'email'),
                'remember' => array_get($data, 'remember'),
            ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.magic_login');
    }
}
