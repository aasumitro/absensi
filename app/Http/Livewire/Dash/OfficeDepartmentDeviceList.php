<?php

namespace App\Http\Livewire\Dash;

use App\Models\Device;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeDepartmentDeviceList extends Component
{
    use WithPagination;

    private int $cache_in_second = 120;

    protected $listeners = ['departmentDeviceListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.office-department-device-list', [
            'devices' => $this->fetchDevices()
        ]);
    }

    private function fetchDevices()
    {
        return Cache::remember(
            'office_department_device_for_root',
            $this->cache_in_second, function ()
        {
            return Device::with('department')
                ->paginate(10);
        });
    }
}
