<?php

namespace App\Traits\User;

/**
 *
 * @file    HasRole.php
 * @author  A. A. Sumitro
 * @email   hello@aasumitro.id
 * @site    https://aasumitro.id
 * @date    2/22/21 - 4:24 PM
 *
 */

trait HasRole
{
    /**
     * Determine if the model has (one of) the given role(s).
     *
     * @param Int|String $role
     * @return bool
     *
     * usage int hasRole(1) string hasRole('role')
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->role->title === $role;
        }

        if (is_int($role)) {
            return $this->role->id === $role;
        }

        return false;
    }
}
