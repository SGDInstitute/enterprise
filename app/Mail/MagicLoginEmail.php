<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

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
        $this->url = url("/login/magic/{$user->magicToken->token}").'?'.http_build_query([
                'email' => Arr::get($data, 'email'),
                'remember' => Arr::get($data, 'remember'),
            ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.magic_login');
    }
}
