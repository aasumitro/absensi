<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Actions\AttendanceFromFile;
use App\Imports\DepartmentAttendanceImport;
use Excel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class StaffAttendanceExcelFile extends Component
{
    use WithFileUploads;

    public $file;

    public $temp;

    public $data;

    protected $listeners = ['staffDepartmentAttendanceFileUploadRefresh' => '$refresh'];

    public function mount()
    {
        $this->data = null;
        $this->temp = null;
    }

    public function render()
    {
        return view('livewire.dash.staff.staff-attendance-excel-file');
    }

    public function previewFileUpload()
    {
        $this->dispatchBrowserEvent('onProcess', ['type' => 'PROCESS']);

        $validatedData = $this->validate(['file' => 'file|mimes:xls']);

        try {
            $import_data = new DepartmentAttendanceImport;

            Excel::import($import_data, $validatedData['file']);

            $this->data = $import_data->getData();
            $this->temp = $this->data;

            $this->dispatchBrowserEvent('onProcess', ['type' => 'DONE']);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[FROM_IMPORT]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('onProcess', ['type' => 'DONE']);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[FROM_IMPORT]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->emit('staffDepartmentAttendanceFileUploadRefresh');
    }

    public function removeDataFromArray($index)
    {
        unset($this->data[$index]);

        $this->dispatchBrowserEvent('showNotify', [
            'type' => 'success',
            'message' => "Action <b>[REMOVE]</b> success"
        ]);

        $this->emit('staffDepartmentAttendanceFileUploadRefresh');
    }

    public function restoreDataFromTemp()
    {
        $this->data = $this->temp;

        $this->dispatchBrowserEvent('showNotify', [
            'type' => 'success',
            'message' => "Action <b>[RESTORE]</b> success"
        ]);

        $this->emit('staffDepartmentAttendanceFileUploadRefresh');
    }

    public function processValidData()
    {
        $this->dispatchBrowserEvent('onProcess', ['type' => 'PROCESS']);

        try {
            (new AttendanceFromFile())->execute($this->data);

            Storage::deleteDirectory('livewire-tmp');

            $this->dispatchBrowserEvent('onProcess', ['type' => 'DONE']);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[PROCESS]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('onProcess', ['type' => 'DONE']);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[PROCESS]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->reset();

        $this->emit('staffDepartmentAttendanceFileUploadRefresh');
    }
}
