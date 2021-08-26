<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class SecretCodeEvent
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \App\Models\User $user
     */
    public User $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
