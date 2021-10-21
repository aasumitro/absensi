<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Models\Attendance;
use App\Models\Device;
use App\Models\User;
use App\Notifications\TelegramAttendNotification;
use Carbon\Carbon;
use Livewire\Component;

class StaffAttendanceManualInput extends Component
{
    public $query;

    public $users;

    public $admin_office;

    public $admin_office_timezone;

    public $selected_user;

    public $date;

    public $time_in;

    public $time_out;

    public $overdue;

    public $overtime;

    public function mount()
    {
        $this->reset();
        $this->admin_office = auth()->user()->profile->department->id;
        $this->admin_office_timezone = auth()->user()->profile->department->timezone->locale;
        $this->date = Carbon::now($this->admin_office_timezone)->format('Y-m-d');
        $this->time_in = Carbon::now($this->admin_office_timezone)->setTimeFrom("08:00")->format('H:i:s');
        $this->time_out = Carbon::now($this->admin_office_timezone)->setTimeFrom("16:00")->format('H:i:s');
        $this->overdue = '0';
        $this->overtime = '0';
    }

    public function selectUser(User $user)
    {
        $this->query = null;

        if ($user->profile->department->id === $this->admin_office) {
            $this->selected_user = $user ?? null;
        } else {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => 'Anda tidak dapat memilih pegawai dari SKPD lain'
            ]);
        }
    }

    public function updatedQuery()
    {
        $this->users = User::where('name', 'like', "%$this->query%")
            ->with('profile.department:id,name')
            ->whereHas('profile.department', function ($query) {
                $query->where('id', $this->admin_office);
            })->get();
    }

    public function submitNewAttendance()
    {
        try {
            $validatedData = $this->validateAndTransform();

            Attendance::create($validatedData);

            if ($this->selected_user->telegram_id) {
                $this->selected_user->notify(new TelegramAttendNotification(
                    "Absensi anda telah diisi oleh " .auth()->user()->name .
                    " untuk tanggal " . $validatedData['date']
                ));
            }

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[NEW_ATTENDANCE]</b> success"
            ]);

            $this->reset('selected_user', 'users', 'date', 'time_in', 'time_out');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[NEW_ATTENDANCE]</b> failed :" . $exception->getMessage()
            ]);
        }
    }

    private function validateAndTransform(): array
    {
        $validatedData = $this->validate([
            'date' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
            'overdue' => 'required',
            'overtime' => 'required',
        ]);

        if (!$this->selected_user) {
            throw new \Exception("Gagal menambah data presensi, Mohon pilih pegawai untuk melanjutkan");
        }

        $attendance = Attendance::where([
            'date' => $validatedData['date'],
            'user_id' => $this->selected_user->id
        ])->first();

        if ($attendance) {
            throw new \Exception("Gagal menambah data presensi, Pegawai sudah melakukan absensi");
        }

        $device = Device::where([
            'department_id' => $this->admin_office,
            'display' => 'DASHBOARD'
        ])->select('id', 'department_id')->first();

        $time_in = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            "{$validatedData['date']} {$validatedData['time_in']}"
        );

        $time_out = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            "{$validatedData['date']} {$validatedData['time_out']}"
        );

        return [
                'user_id' => $this->selected_user->id,
                'device_id' => $device->id,
                'department_id' => $device->department_id,
                'type' => 'NONE',
                'status' => 'ATTEND',
                'date' => $validatedData['date'],
                'datetime_in' => $time_in,
                'datetime_out' => $time_out,
                'timestamp_in' => $time_in->timestamp,
                'timestamp_out' => $time_out->timestamp,
                'overdue' => $validatedData['overdue'],
                'overtime' => $validatedData['overtime'],
                'by' => 'ADMIN/OPERATOR',
                'created_at' => Carbon::now($this->admin_office_timezone),
                'updated_at' => Carbon::now($this->admin_office_timezone)
        ];
    }

    public function render()
    {
        return view('livewire.dash.staff.staff-attendance-manual-input');
    }
}
