<?php

namespace App\Models\Managers;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;

trait RoleManager
{
    private string $fetch_role_key = 'livewire_trait_role_list';

    private function fetchRoles($not_in = [MEMBER_ROLE_ID])
    {
        return Role::whereNotIn('id', $not_in)->get();
    }
}
