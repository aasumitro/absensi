<?php

namespace App\Http\Livewire\Dash;

use App\Models\Device;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class StaffDepartmentDevice extends Component
{
    use WithPagination;

    public $selected_id = 0;

    public $name;

    public $unique_id;

    public $password;
    public $new_password;
    public $renew_password;

    public $refresh_time_mode;

    public $refresh_time;

    private int $cache_in_second = 120;

    protected $listeners = ['staffDepartmentDeviceListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.staff-department-device', [
            'devices' => $this->loadDevice()
        ]);
    }

    public function performAddDevice()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:6',
            'password' => 'required|min:6',
        ]);

        try {
            $user_department_id = auth()->user()->profile->department_id;
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
                'department_id' => $user_department_id,
                'display' => 'DEVICE',
                'name' => $validatedData['name'],
                'password' => \Hash::make($validatedData['password']),
                'refresh_time_mode' => $refresh_time_mode,
                'refresh_time' => $refresh_time,
                'session_token' => Str::random(32)
            ]);

            Cache::forget("office_department_device_for_root_${user_department_id}");

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[CREATE]</b> success",
                'data' => $new_uuid
            ]);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[CREATE]</b> failed"
            ]);
        }

        $this->emit('staffDepartmentDeviceListSectionRefresh');

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'CREATE']
        );

        $this->reset();
    }

    public function selectedDepartmentDevice(Device $device, $action)
    {
        $this->selected_id = $device->id;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );

        if ($action === 'UPDATE') {
            $this->name = $device->name;
            $this->refresh_time_mode = $device->refresh_time_mode;
            $this->refresh_time = $device->refresh_time;
        }
    }

    public function performUpdateDevice()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:6',
            'refresh_time_mode' => 'required',
            'refresh_time' => 'required',
        ]);

        try {
            $user_department_id = auth()->user()->profile->department_id;

            $device = Device::findOrFail($this->selected_id);

            $refresh_time_mode = $validatedData['refresh_time_mode'] ?: "MINUTES";
            $refresh_time = $validatedData['refresh_time'];
            switch (true) {
                case $refresh_time_mode === "MINUTES" && (int)$refresh_time === 0:
                    $refresh_time = 1;
                    break;
                case $refresh_time_mode === "SECONDS" && (int)$refresh_time < 30:
                    $refresh_time = 30;
                    break;
            }

            $device->name = $validatedData['name'];
            $device->refresh_time_mode = $refresh_time_mode;
            $device->refresh_time = $refresh_time;
            $device->save();

            Cache::forget("office_department_device_for_root_${user_department_id}");

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'UPDATE']
        );

        $this->emit('staffDepartmentDeviceListSectionRefresh');

        $this->reset();
    }

    public function performUpdatePassword()
    {
        $validatedData = $this->validate([
            'new_password' => 'required|min:6',
            'renew_password' => 'required|min:6|same:new_password',
        ]);

        try {
            $user_department_id = auth()->user()->profile->department_id;

            Device::where('id', $this->selected_id)
                ->update([
                    'password' => \Hash::make($validatedData['new_password'])
                ]);

            Cache::forget("office_department_device_for_root_${user_department_id}");

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE_PASSWORD]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE_PASSWORD]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'UPDATE_PASSWORD']
        );

        $this->emit('staffDepartmentDeviceListSectionRefresh');

        $this->reset();
    }

    public function performDestroy()
    {
        try {
            $user_department_id = auth()->user()->profile->department_id;

            $device = Device::findOrFail($this->selected_id);

            if ($device->display === 'DASHBOARD')
                throw new \Exception("This device cannot be destroyed");

            $device->delete();

            Cache::forget("office_department_device_for_root_${user_department_id}");

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[DESTROY]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[DESTROY]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'DESTROY']
        );

        $this->emit('staffDepartmentDeviceListSectionRefresh');
    }

    private function loadDevice()
    {
        $user_department_id = auth()->user()->profile->department_id;

        return Cache::remember(
            "office_department_device_for_root_${user_department_id}",
            $this->cache_in_second, function () use ($user_department_id)
        {
            return Device::where('department_id', $user_department_id)
                ->paginate(10);
        });
    }
}
