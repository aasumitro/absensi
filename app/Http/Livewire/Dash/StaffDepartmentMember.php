<?php

namespace App\Http\Livewire\Dash;

use App\Models\Department;
use App\Models\Device;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class StaffDepartmentMember extends Component
{

    public function render()
    {
        return view('livewire.dash.staff-department-member');
    }


}
