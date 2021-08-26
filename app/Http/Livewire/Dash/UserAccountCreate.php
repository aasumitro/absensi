<?php

namespace App\Http\Livewire\Dash;

use App\Models\Department;
use App\Models\Role;
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
            'roles' => Role::all(),
            'departments' =>  Department::all()
        ]);
    }

    public function submit()
    {
        $data = $this->validate();
        $data['unique_id'] = Str::uuid();

        dd($data);
    }
}
