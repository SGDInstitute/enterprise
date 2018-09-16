<?php

namespace App\Mail;

use App\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DonationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param Donation $donation
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
        $this->url = url("/donations/" . $donation->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.donation');
    }
}
