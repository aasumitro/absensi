<?php

namespace App\Models\Managers;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;

trait RoleManager
{
    private string $fetch_role_key = 'livewire_trait_role_list';

    private function fetchRoles()
    {
        return Cache::remember($this->fetch_role_key, $this->cache_time, function ()
        {
            return Role::whereNotIn('id', [4])->get();
        });
    }

}
