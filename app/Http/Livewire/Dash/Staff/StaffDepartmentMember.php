<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Imports\DepartmentUserImport;
use App\Models\Managers\AccountManager;
use App\Models\Managers\RoleManager;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class StaffDepartmentMember extends Component
{
    use WithPagination, RoleManager, AccountManager, WithFileUploads;

    public $selected_id;

    public $department_id;

    public $current_user_role_id;

    public $current_user;

    public $current_user_attendances;

    public $name;

    public $username;

    public $email;

    public $phone;

    public $role;

    public $file;

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
        $this->selected_id = $user->id;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );

        if ($action === 'UPDATE') {
            $this->current_user_role_id = $user->role_id;
            $this->name = $user->name;
            $this->username = $user->username;
            $this->phone = $user->phone;
            $this->email = $user->email;
            $this->role = $user->role_id;
        }

        if ($action === 'DETAIL') {
            $this->current_user = $user;
            $this->current_user_attendances = optional($user->attendances)->slice(0, 5);
        }
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

        try {
            $validatedData['department'] = $this->department_id;

            $this->newAccount($validatedData);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[CREATE]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[CREATE]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'CREATE']
        );

        $this->emit('staffDepartmentPeopleListSectionRefresh');
    }

    public function performAddNewUserFromFile()
    {
        $validatedData = $this->validate(['file' => 'file|mimes:xls']);

        try {
            Excel::import(new DepartmentUserImport, $validatedData['file']);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[FROM_IMPORT]</b> success"
            ]);

            Storage::deleteDirectory('livewire-tmp');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent(
                'openModal',
                ['type' => 'FROM_IMPORT_ERROR']
            );

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[FROM_IMPORT]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'FROM_IMPORT']
        );

        $this->emit('staffDepartmentPeopleListSectionRefresh');
    }

    public function performUpdate()
    {
        $validatedData = $this->validate(['name' => 'required', 'role' => 'required']);

        try {
            $this->modifyAccount($this->selected_id, [
                'role' => ((int)$validatedData['role'] === 0)
                    ? (($this->current_user_role_id === 2) ? 2 : 4)
                    : $validatedData['role'],
                'name' => $validatedData['name'],
                'department' => $this->department_id
            ]);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'UPDATE']
        );

        $this->emit('staffDepartmentPeopleListSectionRefresh');
    }

    public function performResetDevice()
    {
        try {
            $this->giveAccessToNewDevice(User::find($this->selected_id));

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[RESET_PHONE]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[RESET_PHONE]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'RESET_PHONE']
        );

        $this->emit('staffDepartmentPeopleListSectionRefresh');
    }

    public function performDestroy()
    {
        try {
            $this->destroyAccount($this->selected_id);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[DESTROY]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[DESTROY]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'DESTROY']
        );

        $this->emit('staffDepartmentPeopleListSectionRefresh');
    }
}
