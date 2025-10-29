<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpNotification extends Notification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    // Define the delivery channels
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Format the email message
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your OTP Code')
            ->greeting('Hello!')
            ->line('Your OTP code is: ' . $this->otp)
            ->line('It will expire in 5 minutes.')
            ->salutation('Thanks for using our service!');
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
