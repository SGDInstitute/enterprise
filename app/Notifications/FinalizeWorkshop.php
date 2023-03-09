<?php

namespace App\Notifications;

use App\Models\Form;
use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FinalizeWorkshop extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Form $finalize,
        public Response $workshop,
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject("You have a new task to complete for {$this->workshop->name}")
            ->markdown('mail.finalize-workshop', [
                'title' => $this->workshop->name,
                'event' => $this->finalize->event->name,
                'ends' => $this->finalize->end->timezone($this->finalize->event->timezone)->format('F j, Y'),
                'url' => url("/dashboard/workshops?response_id={$this->workshop->id}"),
            ]);
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
