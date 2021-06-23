<?php

namespace App\Models\Concerns;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait HasAttendToken
{
    public function generateAttendToken(): string
    {
        $new_attend_token = Str::random(32);

        $this->attend_token = Hash::make($new_attend_token);
        $this->attend_token_expiry = Carbon::now()->addMinutes(10);
        $this->save();

        return $new_attend_token;
    }

    public function destroyAttendToken(): void
    {
        $this->attend_token = null;
        $this->attend_token_expiry = null;
        $this->save();
    }

    /**
     * @param $attend_token
     * @return bool
     * @throws ValidationException
     */
    public function isAttendTokenValid($attend_token): bool
    {
        if ($this->isTokenExpired()) {
            throw ValidationException::withMessages([
                'token' => "Token is expired",
            ]);
        }

        if (!$this->isTokenMatch($attend_token)) {
            throw ValidationException::withMessages([
                'token' => "Token is not valid",
            ]);
        }

        return true;
    }

    /**
     * @return bool
     */
    private function isTokenExpired(): bool
    {
        return Carbon::now()->gt($this->attend_token_expiry);
    }

    /**
     * @param $attend_token
     * @return bool
     */
    private function isTokenMatch($attend_token): bool
    {
        return password_verify($attend_token, $this->attend_token);
    }
}
