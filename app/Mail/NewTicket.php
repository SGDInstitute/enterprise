<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTicket extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $email;

    public function __construct($subject, $message, $email)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->email = $email;
    }

    public function build()
    {
        return $this->from($this->email)
            ->subject($this->subject)
            ->text('emails.plain.ticket')
            ->with(['message' => $this->message]);
    }
}
