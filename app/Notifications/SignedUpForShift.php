<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SignedUpForShift extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Event $event)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $shifts = $notifiable->shifts()->where('event_id', $this->event->id)->get()
            ->map(fn ($shift) => "{$shift->formattedDuration}: {$shift->name}");

        return (new MailMessage)
            ->subject("Shift Reminder for {$this->event->name}")
            ->line("Thank you for signing up to volunteer for {$this->event->name}.")
            ->lineIf($shifts->isNotEmpty(), 'You have signed up for the following shifts:')
            ->linesIf($shifts->isNotEmpty(), $shifts)
            ->lineIf($shifts->isEmpty(), 'You have not signed up for any shifts.')
            ->action('Change shifts', route('app.volunteer', $this->event));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
