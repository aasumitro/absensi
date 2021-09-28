<?php

namespace App\Http\Livewire\Dash\Root;

use App\Models\Profile;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeDepartmentMemberList extends Component
{
    use WithPagination;

    private int $cache_in_second = 120;

    protected $listeners = ['departmentMemberListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.office-department-member-list', [
            'members' => $this->fetchMembers()
        ]);
    }

    public function fetchMembers()
    {
        return Cache::remember(
            'office_department_member_for_root',
            $this->cache_in_second, function ()
        {
            return Profile::with('user', 'department')
                ->paginate(10);
        });
    }
}
