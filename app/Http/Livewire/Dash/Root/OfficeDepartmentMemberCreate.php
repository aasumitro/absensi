<?php

namespace App\Http\Livewire\Dash\Root;

use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class OfficeDepartmentMemberCreate extends Component
{
    private int $cache_in_second = 120;

    public function render()
    {
        return view('livewire.dash.office-department-member-create', [
            'departments' => $this->fetchDepartment(),
        ]);
    }

    private function fetchDepartment()
    {
        return Cache::remember(
            'departments',
            $this->cache_in_second, function ()
        {
            return Department::all();
        });
    }

//    make auto member
//    make auto uuid
//    make auto
//    private function fetchRoles()
//    {
//        return Cache::remember(
//            'office_department_member_role_except',
//            $this->cache_in_second, function ()
//        {
//            return Role::whereNotIn('id', [1,2,3])->get();
//        });
//    }

}
