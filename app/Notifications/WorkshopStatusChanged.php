<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkshopStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public $response;

    public $comment;

    public $statusChanged;

    public $causer;

    public function __construct($response, $comment, $statusChanged, $causer)
    {
        $this->response = $response;
        $this->comment = $comment;
        $this->statusChanged = $statusChanged;
        $this->causer = $causer;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
                    ->when($this->statusChanged && $this->comment === '', function ($mail) {
                        $mail
                            ->subject('The status of '.$this->response->name.' has changed')
                            ->line("We wanted to let you know that {$this->causer} changed the status of {$this->response->name} to {$this->response->status}.");
                    })
                    ->when($this->statusChanged && $this->comment !== '', function ($mail) {
                        $mail
                            ->subject('The status of '.$this->response->name.' has changed and a comment has been added')
                            ->line("We wanted to let you know that {$this->causer} changed the status of {$this->response->name} to {$this->response->status}.")
                            ->line('Comment: '.$this->comment);
                    })
                    ->when(! $this->statusChanged && $this->comment !== '', function ($mail) {
                        $mail
                            ->subject('A comment has been added to '.$this->response->name)
                            ->line("We wanted to let you know that {$this->causer} added a comment to {$this->response->name}")
                            ->line('Comment: '.$this->comment);
                    })
                    ->action('View Workshop', route('app.forms.show', ['form' => $this->response->form, 'edit' => $this->response]))
                    ->line('If you want to comment please do not reply to this email, login and view the workshop instead.');
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
