<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class RequestAdminEvent
{
    use SerializesModels;

    public User $user;

    public string $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $type)
    {
        $this->user = $user;
        $this->type = $type;
    }
}
