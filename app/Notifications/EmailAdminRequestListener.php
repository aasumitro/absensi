<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailAdminRequestListener extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $title;

    protected string $body;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
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
                ->subject($this->title)
                ->greeting("Hello, $notifiable->name.")
                ->line($this->body);
    }


}
