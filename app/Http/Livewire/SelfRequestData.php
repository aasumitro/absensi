<?php

namespace App\Http\Livewire;

use App\Events\RequestAdminEvent;
use App\Models\Managers\RoleManager;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Exception;
use Livewire\Component;

class SelfRequestData extends Component
{
    use RoleManager;

    public $cache_time = 120;

    public $department_id;

    public $department_timezone;

    public $type;

    public $title;

    public $body;

    public $status;

    public $member_selected_id;

    public $members;

    public $roles;

    public $role;

    public $name;

    public $username;

    public $email;

    public $phone;

    public function mount()
    {
        $this->department_id = auth()->user()->profile->department_id;
        $this->department_timezone = auth()->user()->profile->department->timezone->locale;
        $this->type = "NULL";
        $this->status = "NULL";

        $this->roles = $this->fetchRoles([
            ROOT_ROLE_ID, OPERATOR_ROLE_ID, MEMBER_ROLE_ID
        ]);

        $this->members = DB::table('profiles')
            ->where('department_id', $this->department_id)
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
            ->whereNotIn('users.role_id', [ROOT_ROLE_ID, ADMIN_ROLE_ID])
            ->get();
    }

    public function render()
    {
        return view('livewire.self-request-data');
    }

    public function performNewSuggestion()
    {
        $validatedData = $this->validate([
            'type' => 'required',
            'title' => 'required|min:6',
            'body' => 'required'
        ]);

        try {
            DB::table('requests')->insert([
                'type' => $validatedData['type'],
                'status' => "NONE",
                'value' => json_encode([
                    'title' => $validatedData['title'],
                    'body' => $validatedData['body']
                ]),
                'commit_by' => auth()->user()->id,
                'created_at' => Carbon::now($this->department_timezone),
                'updated_at' => Carbon::now($this->department_timezone)
            ]);

            $this->reset([
                'title', 'body', 'role', 'name', 'username',
                'email', 'phone', 'status', 'type', 'member_selected_id'
            ]);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[NEW_SUGGESTION]</b> success"
            ]);

            $this->dispatchBrowserEvent(
                'openModal',
                [
                    'type' => 'MESSAGE',
                    'title' => 'Formulir Pengajuan',
                    'body' => 'Terimakasih, Pengajuan anda telah dirikim dan akan segera kami proses!'
                ]
            );

            event(new RequestAdminEvent(auth()->user(), 'SUGGEST'));
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[NEW_SUGGESTION]</b> failed, cause: {$exception->getMessage()}"
            ]);
        }
    }

    public function performRequestAdminAccount()
    {
        $value = $this->buildUserData();

        try {
            DB::table('requests')->insert([
                'type' => $this->type,
                'status' => $this->status,
                'value' => json_encode($value),
                'commit_by' => auth()->user()->id,
                'created_at' => Carbon::now($this->department_timezone),
                'updated_at' => Carbon::now($this->department_timezone)
            ]);

            $this->reset([
                'title', 'body', 'role', 'name', 'username',
                'email', 'phone', 'status', 'type', 'member_selected_id'
            ]);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[NEW_ADMIN]</b> success"
            ]);

            $this->dispatchBrowserEvent(
                'openModal',
                [
                    'type' => 'MESSAGE',
                    'title' => 'Formulir Pengajuan',
                    'body' => 'Terimakasih, Pengajuan anda telah dirikim dan akan segera kami proses!'
                ]
            );

            event(new RequestAdminEvent(auth()->user(), 'ADMIN_ACCOUNT_REQUEST'));
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[NEW_ADMIN]</b> failed, cause: {$exception->getMessage()}"
            ]);
        }
    }

    private function buildUserData(): array
    {
        $value = [];

        if ($this->status === 'EXIST') {
            $validatedData = $this->validate([
                'member_selected_id' => 'required'
            ]);

            $user = User::find($validatedData['member_selected_id']);

            $value = [
                'department_id' => $this->department_id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role_id
            ];
        }

        if ($this->status === 'NONE') {
            $validatedData  = $this->validate([
                'name' => 'required',
                'username' => 'required|min:6|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'role' => 'required'
            ]);

            $value = [
                'department_id' => $this->department_id,
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'role' => $validatedData['role']
            ];
        }

        return $value;
    }
}
