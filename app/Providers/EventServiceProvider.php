<?php

namespace App\Providers;

use App\Events\SecretCodeEvent;
use App\Listeners\SendSecretCodeNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SecretCodeEvent::class => [
            SendSecretCodeNotificationListener::class
        ]
    ];
}
