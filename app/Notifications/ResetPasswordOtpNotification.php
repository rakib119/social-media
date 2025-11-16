<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordOtpNotification extends Notification
{
    use Queueable;
    protected $otp;
    /**
     * Create a new notification instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password Reset - Your OTP Code')
            ->greeting('Hello,')
            ->line('We received a request to reset your password. Please use the OTP code below to proceed:')
            ->line('**' . $this->otp . '**')
            // ->line('This code will expire in 10 minutes.')
            ->line('If you did not request a password reset, please ignore this email.')
            // ->action('Reset Password', url('/password-reset'))
            ->line('If you have any questions, please contact our support team.')
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
