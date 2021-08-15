<?php

namespace App\Actions;

use App\Events\SentSecretCodeEvent;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CreateAccessCodeAction
{
    /**
     * @throws ValidationException
     */
    public function execute(string $username) : User
    {
        $user = User::where(['username' => $username])->firstOrFail();

        if (!$user->telegram_id && !$user->email) {
            throw ValidationException::withMessages([
                'username' => "Can't sent secret code, Email or Telegram ID not found!",
            ]);
        }

        event(new SentSecretCodeEvent($user));

        return $user;
    }
}
