<?php

namespace App\Notifications;

use App\Models\Donation;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class DonationReceipt extends Notification
{
    use Queueable;

    public Donation $donation;

    public function __construct($donation)
    {
        $this->donation = $donation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $type = $this->donation->type;
        $receipt = session('was_created', false) ? 'new-account' : 'receipt';

        $subject = Setting::where('group', 'emails.donation-receipt')->where('name', 'subject')->first()->payload;
        $content = Setting::where('group', 'emails.donation-receipt.content')->where('name', "{$type}.{$receipt}")->first()->payload;
        $parsed = Str::of($content)->replace('{amount}', $this->donation->formattedAmount)->replace('{date}', $this->donation->created_at->format('F j, Y'));

        return (new MailMessage())
            ->subject($subject)
            ->markdown('mail.donation-receipt', [
                'subject' => $subject,
                'content' => $parsed,
                'amount' => $this->donation->amount,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
