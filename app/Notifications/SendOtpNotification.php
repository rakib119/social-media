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

    // Format the email message for OTP verification
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->greeting('Welcome!')
            ->line('Thank you for registering with us.')
            ->line('Please use the following One-Time Password (OTP) to verify your email address:')
            ->line('**' . $this->otp . '**')
            // ->line('This code will expire in 5 minutes.')
            ->line('If you did not request this verification, please ignore this email.')
            ->salutation('Best regards, AscentaFlow Team');
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
