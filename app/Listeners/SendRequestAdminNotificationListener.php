<?php

namespace App\Listeners;

use App\Notifications\EmailAdminRequestListener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRequestAdminNotificationListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $type = $event->type;

        $title = '';
        $body = '';

        switch ($type) {
            case "SUGGEST":
                $title = 'Pengajuan';
                $body = 'Terimakasih atas ketersediaan Anda memberikan kritik, saran, masukkan';
                break;
            case "ADMIN_ACCOUNT_REQUEST":
                $title = 'Pengajuan Akun Admin';
                $body = 'Pengajuan Anda, perihal Akun Admin baru akan segera kami proses!';
                break;
            case "ADMIN_ACCOUNT_ACCEPT":
                $title = 'Pengajuan Akun Admin';
                $body = 'Pengajuan akun admin Anda telah diterima!';
                break;
        }

        if ($user->email) {
            $user->notify(new EmailAdminRequestListener($title, $body));
        }
    }
}
