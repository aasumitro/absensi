<?php

namespace App\Listeners;

use App\Events\NewAccountEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewAccountNotificationListener
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
     * @param  NewAccountEvent  $event
     * @return void
     */
    public function handle(NewAccountEvent $event)
    {
        //
    }
}
