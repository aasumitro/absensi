<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Exports\AttendanceByPeopleExport;
use App\Models\Attendance;
use App\Models\User;
use App\Notifications\TelegramExportFileNotification;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class StaffReportByPeoples extends Component
{
    use WithPagination;

    public $query;

    public $department_id;

    public $users;

    public $selected_user;

    public $user_attendances;

    public function mount()
    {
        $this->reset();
        $this->department_id = auth()->user()->profile->department->id;
    }

    public function selectUser(User $user)
    {
        $this->query = null;

        if ($user->profile->department->id === $this->department_id) {
            $this->selected_user = $user ?? null;

            $this->user_attendances = Attendance::where([
                'user_id' => $this->selected_user->id
            ])->with('attachment', 'absentType')->get();
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
                $query->where('id', $this->department_id);
            })->get();
    }

    public function render()
    {
        return view('livewire.dash.staff.staff-report-by-peoples', [
            'attendances' => $this->user_attendances
        ]);
    }

    public function performExportAttendance()
    {
        try {
            $attendances = [];

            foreach ($this->user_attendances as $key => $attendance) {
                $status = (($attendance->status === 'ABSENT') ?("IZIN " . strtoupper($attendance->absentType->description)
                    . "({$attendance->absentType->name})"): "HADIR");

                $attendances[] = [
                    'iteration' => $key+1,
                    'name' => $this->selected_user->name,
                    'department' => $this->selected_user->profile->department->name,
                    'day' => to_indonesia_day(Carbon::parse($attendance->date)->format('l')),
                    'date' => $attendance->date,
                    'status' => $status,
                    'datetime_in' => Carbon::parse($attendance->datetime_in)->format('h:m'),
                    'datetime_out' => Carbon::parse($attendance->datetime_out)->format('h:m'),
                    'overdue' => (($attendance->overdue === 1) ? 'YA' : 'TIDAK'),
                    'overtime' => (($attendance->overtime === 1) ? 'YA' : 'TIDAK')
                ];
            }

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[PROCESS]</b> success"
            ]);

            $file_name = time().".{$this->selected_user->unique_id}.xls";
            $file = (new AttendanceByPeopleExport($attendances))->download(
                $file_name, \Maatwebsite\Excel\Excel::XLS
            );

//            if (auth()->user()->telegram_id) {
//                auth()->user()->notify(new TelegramExportFileNotification(
//                    $file->getFile()->getRealPath(),
//                    $file_name
//                ));
//            }

            return $file;
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[PROCESS]</b> failed :" . $e->getMessage()
            ]);
        }

        return null;
    }
}
