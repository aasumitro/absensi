<?php

namespace App\Listeners;

use App\Notifications\TelegramSecretCodeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentSecretCodeViaTelegramListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;

        $user->notify(new TelegramSecretCodeNotification($user->generateSecretCode()));
    }
}
