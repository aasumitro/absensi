<?php

namespace App\Listeners;

use App\Events\NewAccountEvent;
use App\Notifications\EmailNewAccountNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewAccountNotificationListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  NewAccountEvent  $event
     * @return void
     */
    public function handle(NewAccountEvent $event)
    {
        $user = $event->user;

        $integration_code = $user->generateIntegrationCode();

        if ($user->email) {
            $user->notify(new EmailNewAccountNotification($integration_code));
        }
    }
}
