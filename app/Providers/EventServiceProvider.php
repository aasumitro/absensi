<?php

namespace App\Providers;

use App\Events\SentSecretCodeEvent;
use App\Listeners\SentSecretCodeListener;
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
        SentSecretCodeEvent::class => [
            SentSecretCodeListener::class
        ]
    ];
}
