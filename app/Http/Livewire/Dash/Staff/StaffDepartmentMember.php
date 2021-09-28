<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Models\Managers\AccountManager;
use App\Models\Managers\RoleManager;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StaffDepartmentMember extends Component
{
    use WithPagination, RoleManager, AccountManager;

    public $selected_id;

    public $department_id;

    public $name;

    public $username;

    public $email;

    public $phone;

    public $role;

    public $cache_time = 120;

    protected $listeners = ['staffDepartmentPeopleListSectionRefresh' => '$refresh'];

    public function mount()
    {
        $this->department_id = auth()->user()->profile->department_id;
    }

    public function render()
    {
        return view('livewire.dash.staff-department-member', [
            'members' => $this->fetchAccountByDepartment($this->department_id),
            'roles' => $this->fetchRoles([ROOT_ROLE_ID, ADMIN_ROLE_ID])
        ]);
    }

    public function selectedMemberAccount(User $user, $action)
    {
        dd($user);
    }

    public function performAddNewMember()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'username' => 'required|min:6|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'role' => 'required'
        ]);

        dd($validatedData);
    }

    public function performDestroyMember()
    {

    }
}
