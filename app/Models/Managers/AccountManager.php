<?php

namespace App\Models\Managers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

trait AccountManager
{
    private string $fetch_account_key = 'livewire_trait_users_account_without_member';

    protected function fetchAccounts()
    {
        return Cache::remember($this->fetch_account_key, $this->cache_time, function ()
        {
            return User::with('profile.department', 'role')
                ->whereNotIn('role_id', $this->hide_by_role)
                ->paginate(10);
        });
    }

    protected function newAccount($data)
    {
        $data['unique_id'] = Str::uuid();
        $new_user = $data;
        $new_user['role_id'] = $data['role'];
        unset($new_user['role'], $new_user['department']);

        $create_new_user = User::create($new_user);

        Profile::create([
            'user_id' => $create_new_user->id,
            'department_id' => $data['department']
        ]);

        Cache::forget($this->fetch_account_key);
    }

    protected function modifyAccount($id, $data)
    {
        User::findOrFail($id)->update([
            'role_id' => $data['role'],
            'name' => $data['name'],
        ]);

        Profile::where('user_id', $id)->update([
            'department_id' => $data['department']
        ]);

        Cache::forget($this->fetch_account_key);
    }

    protected function destroyAccount($user_id)
    {
        if ($user_id === 1)
            throw new \Exception("This account cannot destroyed");

        User::destroy($user_id);

        Cache::forget($this->fetch_account_key);
    }
}
