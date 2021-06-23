<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramSecretCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $secret_code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $secret_code)
    {
        $this->secret_code = $secret_code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Telegram\TelegramMessage
     */
    public function toTelegram($notifiable): TelegramMessage
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram_id)
            ->content(trans(
                "notify.new_code",
                ['code' => $this->secret_code]
            ) . ". " . trans(
                    "notify.ignore_message",
                    ['platform' => 'your Email Address']
            ));
    }
}
