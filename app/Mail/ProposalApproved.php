<?php

namespace App\Mail;

use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProposalApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Response $response,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Proposal Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.proposal-approved',
            with: [
                'url' => route('app.forms.show', ['form' => $this->response->form, 'edit' => $this->response]),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
