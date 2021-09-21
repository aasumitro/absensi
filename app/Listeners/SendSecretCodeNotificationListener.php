<?php

namespace App\Listeners;

use App\Events\SecretCodeEvent;
use App\Notifications\EmailSecretCodeNotification;
use App\Notifications\TelegramSecretCodeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\ValidationException;

class SendSecretCodeNotificationListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     * @throws ValidationException
     */
    public function handle(SecretCodeEvent $event)
    {
        $user = $event->user;

        $secret_code = $user->generateSecretCode();

        if ($user->telegram_id) {
            $user->notify(new TelegramSecretCodeNotification($secret_code));
        }

        if ($user->email) {
            $user->notify(new EmailSecretCodeNotification($secret_code));
        }
    }
}
