<?php

namespace App\Http\Livewire\Dash;

use App\Models\Department;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeDepartmentList extends Component
{
    use WithPagination;

    private int $cache_in_second = 120;

    protected $listeners = ['departmentListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.office-department-list', [
            'departments' => $this->fetchDepartments()
        ]);
    }

    public function fetchDepartments() {
        return Cache::remember(
            'office_department_for_root',
            $this->cache_in_second, function ()
        {
            return Department::withCount('devices', 'members')
                ->paginate(10);
        });
    }
}
