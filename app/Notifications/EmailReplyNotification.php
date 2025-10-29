<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailReplyNotification extends Notification
{
    use Queueable;
    protected $request;
    /**
     * Create a new notification instance.
     */
    public function __construct($request)
    {

        $this->request = $request;
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

        //get subject and message from the request

        $subject = $this->request->subject;
        $name    = $this->request->name;
        $message = $this->request->message;

        return (new MailMessage)
                    ->subject($subject)
                    ->greeting('Dear !'.$name)
                    ->line($message) //
                    ->line('If you have any further questions, feel free to reply to this email.Thank you for contacting us!')
                    ->salutation('Best regards,')
                    ->salutation('Ascentaverse Support Team');
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
