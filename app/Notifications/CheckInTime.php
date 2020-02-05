<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Expo\ExpoChannel;
use NotificationChannels\Expo\ExpoMessage;

class CheckInTime extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ExpoChannel::class];
    }

    public function toExpo($notifiable)
    {
        return (new ExpoMessage)
            ->title("It's time to check in!")
            ->body('Check in now for us to print your name badge')
            ->setJsonData(['screen' => 'Checkin']);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
