<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Models\AbsentType;
use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Livewire\Component;

class StaffReportByDates extends Component
{
    public $from_date;

    public $to_date;

    public $absent_type_id;

    public $department_id;

    public $page = 1;

    protected $queryString = [
        'from_date',
        'to_date',
        'absent_type_id',
        'page' => ['except' => 1],
    ];

    protected $listeners = ['staffAttendancesByRangeDateSectionRefresh' => '$refresh'];

    public function mount()
    {
        $this->to_date = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->department_id = auth()->user()->profile->department_id;
        $this->absent_type_id = 'ALL';
    }

    public function render()
    {
        return view('livewire.dash.staff.staff-report-by-dates', [
            'absentTypes' => AbsentType::all(),
            'attendances' => $this->loadAttendances()
        ]);
    }

    public function performExportData($type = 'xls')
    {
        // TODO HERE
        dd($type);
    }

    private function loadAttendances(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $attendances = Attendance::with(
            'absentType', 'department', 'device', 'user', 'attachment'
        )->where(
            'created_at', '>=',
            Carbon::parse($this->from_date)->format('Y-m-d 00:00:00')
        )->where(
            'created_at', '<=',
                Carbon::parse($this->to_date)->format('Y-m-d 23:59:59')
        );

        if ((string) $this->absent_type_id !== 'ALL') {
            if (is_int($this->absent_type_id)) {
                $attendances->where('absent_type_id', $this->absent_type_id);
            } else {
                $attendances->where('status', $this->absent_type_id);
            }
        }

        $attendances->orderBy('date', 'DESC');

        return $attendances->paginate(10);
    }
}
