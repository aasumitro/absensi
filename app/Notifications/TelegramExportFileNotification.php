<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramFile;

class TelegramExportFileNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $content;

    protected string $content_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $content, string $content_name)
    {
        $this->content = $content;
        $this->content_name = $content_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    // Not work yet
    // and will be fixing on next release
    // according to : https://github.com/laravel-notification-channels/telegram/issues/105
    public function toTelegram($notifiable)
    {
        return TelegramFile::create()
            ->to($notifiable->telegram_user_id)
            ->content('Data berhasil di export')
            ->file(
                $this->content,
                'document',
                $this->content_name
            );
    }
}
