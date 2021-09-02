<?php

namespace App\Http\Livewire\Dash;

use App\Models\Managers\AccountManager;
use App\Models\Managers\DepartmentManager;
use App\Models\Managers\RoleManager;
use App\Models\User;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class UserAccountList extends Component
{
    use WithPagination, DepartmentManager, RoleManager, AccountManager;

    private array $hide_by_role = [4];

    public $selected_id;

    public $unique_id;

    public $name;

    public $email;

    public $phone;

    public $username;

    public $role;

    public $department;

    protected int $cache_time = 120;

    protected $listeners = ['accountListSectionRefresh' => '$refresh'];

    protected $rules = [
        'name' => 'required|min:6',
        'role' => 'required',
        'department' => 'required',
    ];

    public function render()
    {
        return view('livewire.dash.user-account-list', [
            'users' => $this->fetchAccounts(),
            'roles' => $this->fetchRoles(),
            'departments' => $this->fetchDepartments()
        ]);
    }

    public function selectedAccount(User $user, $action): void
    {
        $this->selected_id = $user->id;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );

        if ($action === 'UPDATE') {
            $this->unique_id = $user->unique_id;
            $this->username = $user->username;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->name = $user->name;
            $this->role = $user->role_id;
            $this->department = $user->profile->department_id;
        }
    }

    public function performDestroy(int $user_id): void
    {
        try {
            $this->destroyAccount($user_id);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[DESTROY]</b> success"
            ]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[DESTROY]</b> failed"
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'DESTROY']
        );

        $this->emit('accountListSectionRefresh');
    }

    public function performUpdate()
    {
        $data = $this->validate();

        try {
            $this->modifyAccount($this->selected_id, $data);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed"
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'UPDATE']
        );

        $this->emit('accountListSectionRefresh');
    }
}
