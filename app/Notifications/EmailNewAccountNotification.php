<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EmailNewAccountNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $integration_code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $integration_code)
    {
        $this->integration_code = $integration_code;
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
        // akun baru kirim instruksi hubungkan akun telegram dan akun oksetda
        // kirim integration code dan cara integrasi
        // mulai dari konek telegram akun dan oksetda akun
        // verifikasi dan coba login lewat aplikasi
        // untuk mendapatkan OTP
        return (new MailMessage)
                    ->subject("Akun baru")
                    ->greeting("Halo, $notifiable->name.")
                    ->line("Selamat datang di OkSetda Absensi, Akun anda telah dibuat oleh admin")
                    ->line("Mohon ikuti instruksi dibawah ini untuk mengakses akun anda: ")
                    ->line(new HtmlString("1. Unduh <a href='https://play.google.com/store/apps/details?id=org.telegram.messenger&hl=in&gl=US'>Telegram Messenger</a>"))
                    ->line(new HtmlString("2. Hubungkan dengan <a href='https://t.me/OkSetdaBot'>OkSetdaBot</a>"))
                    ->line(new HtmlString("3. Integrasi akun OkSetda Absensi dan OkSetdaBot dengan mengirimkan pesan berformat: <br> <b>CONNECT#USERNAME#INTEGRATION_CODE </b>"))
                    ->line(new HtmlString("<br>"))
                    ->line(new HtmlString("<b>Nama Pengguna Anda:</b> <span style='border-style: solid; padding: 3px;'>$notifiable->username</span>"))
                    ->line(new HtmlString("<b>Kode Integrasi Anda:</b> <span style='border-style: solid; padding: 3px;'>$this->integration_code</span>"))
                    ->line(new HtmlString("<br>"))
                    ->line('Terima kasih telah menggunakan aplikasi ini!');
    }

}
