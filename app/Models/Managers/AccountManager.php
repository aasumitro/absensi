<?php

namespace App\Models\Managers;

use App\Events\NewAccountEvent;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait AccountManager
{
    protected function fetchAccounts(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::with('profile.department', 'role')
            ->whereNotIn('role_id', $this->hide_by_role)
            ->paginate(10);
    }

    protected function fetchAccountByDepartment($department_id): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Profile::with(['department', 'user.role'])
            ->where('department_id', $department_id)
            ->paginate(10);
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

        event(new NewAccountEvent($create_new_user));
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
    }

    protected function destroyAccount($user_id)
    {
        if ($user_id === 1 || $user_id === \auth()->user()->id)
            throw new \Exception(" Anda tidak memiliki izin untuk menghapus akun ini.");

        User::destroy($user_id);
    }

    protected function modifyAvatar($file): bool
    {
       $user = Auth::user();

       if (is_file($file['file'])) {
           $file_name ="{$user->unique_id}.{$file['file']->getClientOriginalExtension()}";
           $file_path = 'public/uploads/images/avatar';
           $file['file']->storeAs($file_path, $file_name);
           $user->avatar =  $file_name;
       } else {
           $user->avatar = null;
       }

        return $user->save();
    }

    protected function modifyPhoneId(string $phone_id): bool
    {
        $user = Auth::user();

        $user->phone_id = $phone_id;

        return $user->save();
    }

    protected function modifyTelegramId(string $telegram_id): bool
    {
        $user = Auth::user();

        $user->telegram_id = $telegram_id;

        return $user->save();
    }

    protected function modifyFCMToken(string $fcm_token): bool
    {
        $user = Auth::user();

        $user->fcm_token = $fcm_token;

        return $user->save();
    }

    protected function giveAccessToNewDevice(User $user): bool
    {
        $user->phone_id = null;

        return $user->save();
    }
}
