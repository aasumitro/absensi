<?php

namespace App\Http\Livewire\Dash\Root;

use App\Models\Department;
use App\Models\Managers\AccountManager;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeDepartmentMemberList extends Component
{
    use WithPagination, AccountManager;

    public $username;

    public $email;

    public $phone;

    public $name;

    public $department;

    public $selected_id;

    public $selected_user;

    protected $listeners = ['departmentMemberListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.office-department-member-list', [
            'members' => Profile::with('user', 'department')->paginate(10),
            'departments' => Department::all()
        ]);
    }

    public function selectedMember(User $user, string $action)
    {
        $this->selected_id = $user->id;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );

        if ($action === 'UPDATE') {
            $this->selected_user = $user;
            $this->username = $user->username;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->name = $user->name;
            $this->department = $user->profile->department_id;
        }
    }

    public function performAddMember()
    {
        $data = $this->validate([
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone|min:9',
            'username' => 'required|min:6|unique:users,username',
            'department' => 'required',
        ]);

        try {
            $data['role'] = MEMBER_ROLE_ID;

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

        $this->emit('departmentMemberListSectionRefresh');

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'CREATE']
        );

        $this->reset();
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
                'message' => "Action <b>[DESTROY]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'DESTROY']
        );

        $this->emit('departmentMemberListSectionRefresh');
    }

    public function performUpdateMember()
    {
        $data = $this->validate([
            'name' => 'required|min:6',
            'department' => 'required',
        ]);

        try {
            $data['role'] = ((int)$this->selected_user->role_id === ROOT_ROLE_ID
                ? $this->selected_user->role_id
                : MEMBER_ROLE_ID);

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

        $this->emit('departmentMemberListSectionRefresh');
    }
}
