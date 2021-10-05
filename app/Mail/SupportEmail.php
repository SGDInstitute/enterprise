<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this
            ->from('support@sgdinstitute.org')
            ->subject('Gemini Contact Form:' . $this->contact['subject'])
            ->replyTo($this->contact['email'], $this->contact['name'])
            ->text('mail.support-email')
            ->with([
                'contact' => $this->contact,
            ]);
    }
}
