<?php

namespace App\Listeners;

use App\Events\AttendEvent;
use App\Notifications\FCMAttendNotification;
use App\Notifications\TelegramAttendNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAttendNotificationListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AttendEvent $event)
    {
        $user = $event->user;

        if ($user->telegram_id) {
            $user->notify(new TelegramAttendNotification($event->message));
        }

        if ($user->fcm_token) {
            $user->notify(new FCMAttendNotification($event->message));
        }
    }
}
