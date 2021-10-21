<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Exports\AttendanceByPeopleExport;
use App\Models\AbsentType;
use App\Models\Attendance;
use App\Models\User;
use Excel;
use Livewire\Component;
use Livewire\WithPagination;

class StaffReportByPeoples extends Component
{
    use WithPagination;

    public $query;

    public $department_id;
    public $department_name;

    public $users;

    public $selected_user;

    public $user_attendances;

    public $user_attend_count;
    public $user_attend_overtime_count;
    public $user_absent_count;
    public $user_absent_sick_count;
    public $user_absent_leave_count;
    public $user_absent_missing_count;

    public function mount()
    {
        $this->reset();
        $this->department_id = auth()->user()->profile->department->id;
        $this->department_name = auth()->user()->profile->department->name;
        $this->user_attend_count = 0;
        $this->user_absent_count = 0;
        $this->user_attend_overtime_count = 0;
        $this->user_absent_sick_count = 0;
        $this->user_absent_leave_count = 0;
        $this->user_absent_missing_count = 0;
    }

    public function selectUser(User $user)
    {
        $this->query = null;

        if ($user->profile->department->id === $this->department_id) {
            $this->selected_user = $user ?? null;

            $this->user_attendances = Attendance::where([
                'user_id' => $this->selected_user->id
            ])->with('attachment', 'absentType')->orderBy('date', 'DESC')->get();

            $this->user_attend_count = count(array_filter(
                $this->user_attendances->toArray(),
                function($item) {
                    return $item['status'] === 'ATTEND';
                }));

            $this->user_attend_overtime_count = count(array_filter(
                $this->user_attendances->toArray(),
                function($item) {
                    return $item['status'] === 'ATTEND' && (int)$item['overdue'] === 1;
                }));

            $this->user_absent_count = count(array_filter(
                $this->user_attendances->toArray(),
                function($item) {
                    return $item['status'] === 'ABSENT';
                }));

            $this->user_absent_sick_count = count(array_filter(
                $this->user_attendances->toArray(),
                function($item) {
                    return $item['status'] === 'ABSENT' &&
                        (int)$item['absent_type_id'] === AbsentType::SAKIT;
                }));

            $this->user_absent_leave_count = count(array_filter(
                $this->user_attendances->toArray(),
                function($item) {
                    return $item['status'] === 'ABSENT' &&
                        (int)$item['absent_type_id'] === AbsentType::CUTI;
                }));

            $this->user_absent_missing_count = count(array_filter(
                $this->user_attendances->toArray(),
                function($item) {
                    return $item['status'] === 'ABSENT' &&
                        (int)$item['absent_type_id'] === AbsentType::TANPA_KETERANGAN;
                }));
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
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[PROCESS]</b> success"
            ]);

            $file_name = time().".{$this->selected_user->unique_id}.xls";

            $data = [
                'name' => $this->selected_user->name,
                'department' => $this->department_name,
                'attend_total' => $this->user_attend_count,
                'attend_overtime_total' => $this->user_attend_overtime_count,
                'absent_total' => $this->user_absent_count,
                'absent_sick_total' => $this->user_absent_sick_count,
                'absent_leave_total' => $this->user_absent_leave_count,
                'absent_missing_total' => $this->user_absent_missing_count,
                'attendances' => collect($this->user_attendances->toArray())->sortBy('date')->all()
            ];

//            dd($data);

            return Excel::download(new AttendanceByPeopleExport($data), $file_name);

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[PROCESS]</b> failed :" . $e->getMessage()
            ]);
        }

        return null;
    }
}
