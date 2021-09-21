<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class AttendEvent
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \App\Models\User $user
     */
    public User $user;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $message)
    {
        $this->user = $user;
        $this->message = $message;
    }
}
