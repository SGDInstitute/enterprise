<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResponseConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $response;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('pdf.response', [
            'response' => $this->response,
            'form' => $this->response->form->form
        ]);

        return $this->subject($this->response->form->name . " Submission Confirmation")
            ->markdown('emails.response_confirmation', [
                'response' => $this->response,
            ])
            ->attachData($pdf->output(), 'response.pdf');
    }
}
