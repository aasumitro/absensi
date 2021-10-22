<?php

namespace App\Providers;

use App\Events\AttendEvent;
use App\Events\NewAccountEvent;
use App\Events\RequestAdminEvent;
use App\Events\SecretCodeEvent;
use App\Listeners\SendAttendNotificationListener;
use App\Listeners\SendNewAccountNotificationListener;
use App\Listeners\SendRequestAdminNotificationListener;
use App\Listeners\SendSecretCodeNotificationListener;
use App\Models\Attendance;
use App\Models\Submission;
use App\Observers\AttendanceObserver;
use App\Observers\SubmissionObserver;
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
        ],
        NewAccountEvent::class => [
            SendNewAccountNotificationListener::class
        ],
        AttendEvent::class => [
            SendAttendNotificationListener::class
        ],
        RequestAdminEvent::class => [
            SendRequestAdminNotificationListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Attendance::observe(AttendanceObserver::class);
        Submission::observe(SubmissionObserver::class);
    }
}
