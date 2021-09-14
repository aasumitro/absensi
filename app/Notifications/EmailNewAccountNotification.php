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
                    ->subject("New Account")
                    ->greeting("Hello, $notifiable->name.")
                    ->line("Welcome to OkSetda Absensi, your account just created by Admin")
                    ->line("Please follow this instruction below to access your account: ")
                    ->line(new HtmlString("1. Download <a href='https://play.google.com/store/apps/details?id=org.telegram.messenger&hl=in&gl=US'>Telegram Messenger</a>"))
                    ->line(new HtmlString("2. Connect with <a href='https://t.me/OkSetdaBot'>OkSetdaBot</a>"))
                    ->line(new HtmlString("3. Integrate your OkSetda Absensi Account with OkSetdaBot by send an message instruction by this format below : <br> <b>CONNECT#USERNAME#INTEGRATION_CODE </b>"))
                    ->line(new HtmlString("<br>"))
                    ->line(new HtmlString("<b>Your Username:</b> $notifiable->username"))
                    ->line(new HtmlString("<b>Your Integration Code:</b> $this->integration_code"))
                    ->line(new HtmlString("<br>"))
                    ->line('Thank you for using our application!');
    }

}
