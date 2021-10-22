<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailSecretCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $secret_code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(String $secret_code)
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Kode verifikasi melalui alamat email")
            ->greeting("Halo, $notifiable->name!")
            ->line("Kode akses anda adalah: $this->secret_code, kode hanya berlaku dalam 10 menit. Abaikan pesan ini jika Anda sudah menerima kode melalui Telegram Messenger!")
            ->line('Terimakasih telah menggunana aplikasi ini!');
    }
}
