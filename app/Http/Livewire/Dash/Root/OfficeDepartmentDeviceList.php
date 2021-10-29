<?php

namespace App\Http\Livewire\Dash\Root;

use App\Models\Department;
use App\Models\Device;
use Exception;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeDepartmentDeviceList extends Component
{
    use WithPagination;

    public $name;

    public $department;

    public $password;

    public $refresh_time_mode;

    public $refresh_time;

    public $selected_id;

    protected $listeners = ['departmentDeviceListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.office-department-device-list', [
            'devices' => Device::with('department')->paginate(10),
            'departments' => Department::all()
        ]);
    }

    public function selectedDevice(Device $device, string $action)
    {
        $this->selected_id = $device->id;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );

        if ($action === 'UPDATE') {
            $this->name = $device->name;
            $this->department = $device->department_id;
            $this->refresh_time_mode = $device->refresh_time_mode;
            $this->refresh_time = $device->refresh_time;
        }
    }

    public function performDestroy()
    {
        try {
            Device::findOrFail($this->selected_id)->delete();

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[DESTROY]</b> success"
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[DESTROY]</b> failed :" . $exception->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'DESTROY']
        );

        $this->emit('departmentDeviceListSectionRefresh');
    }

    public function performCreate()
    {
        $data = $this->validate([
            'name' => 'required|min:6',
            'password' => 'required|min:6',
            'department' => 'required',
        ]);

        try {
            $new_uuid = Str::uuid();
            $refresh_time_mode = $this->refresh_time_mode ?: "MINUTES";
            $refresh_time = $this->refresh_time;

            switch (true) {
                case $refresh_time_mode === "MINUTES" && (int)$refresh_time === 0:
                    $refresh_time = 1;
                    break;
                case $refresh_time_mode === "SECONDS" && (int)$refresh_time < 30:
                    $refresh_time = 30;
                    break;
            }

            Device::create([
                'unique_id' => $new_uuid,
                'department_id' => $data['department'],
                'display' => 'DEVICE',
                'name' => $data['name'],
                'password' => \Hash::make($data['password']),
                'refresh_time_mode' => $refresh_time_mode,
                'refresh_time' => $refresh_time,
                'session_token' => Str::random(32)
            ]);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[CREATE]</b> success",
                'data' => $new_uuid
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[CREATE]</b> failed :" . $exception->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'CREATE']
        );

        $this->emit('departmentDeviceListSectionRefresh');
    }
}
