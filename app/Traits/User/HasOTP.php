<?php

namespace App\Traits\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 *
 * @file    HasOTP.php
 * @author  A. A. Sumitro
 * @email   hello@aasumitro.id
 * @site    https://aasumitro.id
 * @date    2/22/21 - 9:36 PM
 *
 */

trait HasOTP
{
    public function generateSecretCode(): string
    {
        $new_one_time_password = random_int(1000000,9999999);
        $this->passwordless = Hash::make($new_one_time_password);
        $this->passwordless_expiry = Carbon::now()->addMinutes(10);
        $this->save();

        return $new_one_time_password;
    }

    public function destroySecretCode(): void
    {
        $this->passwordless = null;
        $this->passwordless_expiry = null;
        $this->save();
    }

    /**
     * @param $one_time_password
     * @return bool
     * @throws ValidationException
     */
    public function isCodeValid($one_time_password)
    {
        if ($this->isCodeExpired()) {
            throw ValidationException::withMessages([
                'password' => trans("auth.expired"),
            ]);
        }

        if (!$this->isCodeMatch($one_time_password)) {
            throw ValidationException::withMessages([
                'password' => trans("auth.combination.password"),
            ]);
        }

        return true;
    }

    /**
     * @return bool
     */
    private function isCodeExpired(): bool
    {
        return Carbon::now()->gt($this->passwordless_expiry);
    }

    /**
     * @param $one_time_password
     * @return bool
     */
    private function isCodeMatch($one_time_password): bool
    {
        return password_verify($one_time_password, $this->passwordless);
    }
}
