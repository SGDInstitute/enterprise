<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdatedCard extends Notification
{
    use Queueable;

    public $card;

    /**
     * Create a new notification instance.
     *
     * @param $card
     */
    public function __construct($card)
    {
        $this->card = $card;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Updated Credit Card on your SGD Institute Account')
            ->line('The credit card on file for your account has been updated.')
            ->line('Your new card on file is a ' . $this->card->brand . ' ending in ' . $this->card->last4)
            ->line('If you did not make this change, please contact us immediately')
            ->action('Contact Us', 'mailto:support@sgdinstitute.org');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
