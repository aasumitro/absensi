<?php

namespace App\Http\Livewire\Dash\Root;

use App\Models\Managers\AccountManager;
use App\Models\Managers\DepartmentManager;
use App\Models\Managers\RoleManager;
use Exception;
use Livewire\Component;

class UserAccountCreate extends Component
{
    use RoleManager, DepartmentManager, AccountManager;

    public $name;

    public $email;

    public $phone;

    public $username;

    public $role;

    public $department;

    protected int $cache_time = 120;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|unique:users,phone',
        'username' => 'required|min:6|unique:users,username',
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

    public function submit()
    {
        $data = $this->validate();

        try {
            $this->newAccount($data);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[CREATE]</b> success"
            ]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[CREATE]</b> failed"
            ]);
        }

        $this->emit('accountListSectionRefresh');

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'CREATE']
        );

        $this->reset();
    }
}
