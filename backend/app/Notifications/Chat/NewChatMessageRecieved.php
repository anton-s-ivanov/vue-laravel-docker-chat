<?php

namespace App\Notifications\Chat;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewChatMessageRecieved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $messageSenderId;
    
    /**
     * Create a new notification instance.
     */
    public function __construct($messageSenderId)
    {
        $this->messageSenderId = $messageSenderId;
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
    public function toMail(): MailMessage
    {
        $text = 'В чате с '
            . User::findOrFail($this->messageSenderId)->name 
            .' - новое сообщение';
        
        return (new MailMessage)
                    ->subject('Новое сообщение в чате')
                    ->greeting(' ')
                    ->line($text)
                    ->salutation(' ')
                    ;
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
