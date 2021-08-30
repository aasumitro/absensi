<?php

namespace App\Http\Livewire\Dash;

use App\Models\Department;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class UserAccountCreate extends Component
{
    public $name;

    public $email;

    public $phone;

    public $username;

    public $role;

    public $department;

    private int $cache_in_second = 120;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'phone' => 'required',
        'username' => 'required|min:6',
        'role' => 'required',
        'department' => 'required',
    ];

    public function render()
    {
        return view('livewire.dash.user-account-create', [
            'roles' => $this->fetchRoles(),
            'departments' =>  $this->fetchDepartments()
        ]);
    }

    private function fetchRoles()
    {
        return Cache::remember(
            'user_account_role_list_except',
            $this->cache_in_second, function ()
        {
            return Role::whereNotIn('id', [4])->get();
        });
    }

    private function fetchDepartments()
    {
        return Cache::remember(
            'user_account_department_list',
            $this->cache_in_second, function ()
        {
            return Department::all();
        });
    }

    public function submit()
    {
        $data = $this->validate();
        $data['unique_id'] = Str::uuid();

        $new_user = $data;
        $new_user['role_id'] = $data['role'];
        unset($new_user['role'], $new_user['department']);

        try {
            $create_new_user = User::create($new_user);

            Profile::create([
                'user_id' => $create_new_user->id,
                'department_id' => $data['department']
            ]);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[CREATE]</b> success"
            ]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[CREATE]</b> failed"
            ]);
        }

        $this->emit('accountListSectionRefresh');

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'CREATE']
        );

        Cache::forget('users_account_without_member');

        $this->reset();
    }
}
