<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContributionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;
    public $url;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
        $this->url = url('/donations/'.$donation->id);
    }

    public function build()
    {
        return $this->markdown('emails.contribution');
    }
}
