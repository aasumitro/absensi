<?php

namespace App\Http\Livewire\Dash\Root;

use App\Models\Department;
use App\Models\Device;
use App\Models\Timezone;
use Exception;
use Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class OfficeDepartmentList extends Component
{
    use WithPagination;

    public $timezone;

    public $name;

    public $max_att_in;

    public $min_att_out;

    public $min_att_acc;

    public $max_att_acc;

    public $selected_id;

    protected $listeners = ['departmentListSectionRefresh' => '$refresh'];

    public function mount()
    {
       $this->resetData();
    }

    private function resetData()
    {
        $this->timezone = 2;
        $this->max_att_in = "08:00";
        $this->min_att_out = "16:30";
        $this->min_att_acc = "180";
        $this->max_att_acc = "60";
    }

    private function validateData(): array
    {
        return $this->validate([
            'name' => 'required|min:6',
            'timezone' => 'required',
            'max_att_in' => 'required',
            'min_att_out' => 'required',
            'min_att_acc' => 'required',
            'max_att_acc' => 'required',
        ]);
    }

    public function render()
    {
        return view('livewire.dash.office-department-list', [
            'departments' => Department::with('timezone')
                ->withCount('devices', 'members')
                ->paginate(5),
            'timezones' => Timezone::all()
        ]);
    }

    public function selectedDepartment(Department $department, string $action)
    {
        $this->selected_id = $department->id;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );

        if ($action === 'UPDATE') {
            $this->name = $department->name;
            $this->timezone = $department->timezone_id;
            $this->max_att_in = $department->max_att_in;
            $this->min_att_out = $department->min_att_out;
            $this->min_att_acc = $department->min_att_acc;
            $this->max_att_acc = $department->max_att_acc;
        }
    }

    public function performCreate()
    {
        $data = $this->validateData();

        try {
            $data['timezone_id'] = $data['timezone'];
            unset($data['timezone']);

            $department = Department::create($data);

            Device::create([
                'department_id' => $department->id,
                'display' => 'DASHBOARD',
                'name' => "[{$data['name']}] default",
                'unique_id' => Str::uuid(),
                'password' => Hash::make('secret'),
                'session_token' => Str::random(32)
            ]);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[CREATE]</b> success"
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[CREATE]</b> failed" . $exception->getMessage()
            ]);
        }

        $this->emit('departmentListSectionRefresh');

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'CREATE']
        );
    }

    public function performUpdate()
    {
        $data = $this->validateData();

        try {
            $data['timezone_id'] = $data['timezone'];
            unset($data['timezone']);

            Department::where('id', $this->selected_id)->update($data);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[CREATE]</b> failed" . $exception->getMessage()
            ]);
        }

        $this->emit('departmentListSectionRefresh');

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'UPDATE']
        );
    }

    public function performDestroy()
    {
        try {
            Department::findOrFail($this->selected_id)->delete();

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[DESTROY]</b> success"
            ]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[DESTROY]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'DESTROY']
        );

        $this->emit('departmentListSectionRefresh');
    }
}
