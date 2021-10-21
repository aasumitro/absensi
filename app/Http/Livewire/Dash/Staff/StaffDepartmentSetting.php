<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Models\Department;
use App\Models\Timezone;
use Livewire\Component;

class StaffDepartmentSetting extends Component
{
    public $department;

    public $zone;

    public $name;

    public $latitude;

    public $longitude;

    public $max_att_in;

    public $min_att_out;

    public $min_att_acc;

    public $max_att_acc;

    public $member_count = 0;

    public $device_count = 0;

    public $attendace_count = 0;

    protected $listeners = ['staffDepartmentSettingSectionRefresh' => '$refresh'];

    public function mount()
    {
        $this->department = $this->loadDepartment();

        $this->member_count = $this->department->members_count;
        $this->device_count = $this->department->devices_count;
        $this->attendance_count = $this->department->attendances_count;
        $this->zone = $this->department->timezone->id;

        $this->name = $this->department->name;
        $this->latitude = $this->department->latitude;
        $this->longitude = $this->department->longitude;
        $this->max_att_in = $this->department->max_att_in;
        $this->min_att_out = $this->department->min_att_out;
        $this->min_att_acc = $this->department->min_att_acc;
        $this->max_att_acc = $this->department->max_att_acc;
    }

    public function render()
    {
        $timezones = Timezone::all();

        return view('livewire.dash.staff-department-setting', [
            'timezones' => $timezones,
        ]);
    }

    public function performUpdateDepartment()
    {
        try {
            $this->department->name = $this->name;
            $this->department->latitude = $this->latitude;
            $this->department->longitude = $this->longitude;
            $this->department->max_att_in = $this->max_att_in;
            $this->department->min_att_out = $this->min_att_out;
            $this->department->save();

            $this->department = $this->loadDepartment();

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success",
                'data' =>  $this->department->timezone->locale
            ]);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed"
            ]);
        }

        $this->emit('staffDepartmentSettingSectionRefresh');
    }

    public function performUpdateTimezone()
    {
        try {
            $this->department->timezone_id = $this->zone;
            $this->department->save();

            $this->department = $this->loadDepartment();

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success",
                'data' => $this->department->timezone->locale
            ]);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed"
            ]);
        }

        $this->emit('staffDepartmentSettingSectionRefresh');
    }

    private function loadDepartment()
    {
        return Department::with('timezone')
            ->withCount('attendances', 'devices', 'members')
            ->where('id', auth()->user()->profile->department_id)
            ->first();
    }
}
