<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Exports\AttendanceByDateFormatDetail;
use App\Exports\AttendanceByDateFormatTotal;
use App\Models\AbsentType;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Profile;
use Excel;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class StaffReportByDates extends Component
{
    use WithPagination;

    public $format;

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
        $this->format = "DETAIL";
    }

    public function render()
    {
        return view('livewire.dash.staff.staff-report-by-dates', [
            'absentTypes' => AbsentType::all(),
            'attendances' => ($this->format === 'DETAIL')
                ? $this->loadAttendancesFormatDetail()->paginate(15)
                : $this->loadAttendancesFormatTotal()->paginate(15)
        ]);
    }

    public function performExportData()
    {
        try {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[PROCESS]</b> success"
            ]);

            $file_name = time().'.'.\Str::slug(auth()->user()->profile->department->name).".{$this->format}".".xls";
            $department = Department::withCount('members')->with('timezone')->find($this->department_id);

            if ($this->format === "TOTAL") {
                $data = [
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'department' => $department,
                    'attendances' => collect($this->loadAttendancesFormatTotal()->get()->toArray())->all()
                ];

                return Excel::download(new AttendanceByDateFormatTotal($data), $file_name);
            }

            if ($this->format === 'DETAIL') {
                $data = [
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'department' => $department,
                    'attendances' => collect($this->loadAttendancesFormatDetail()->get()->toArray())->all()
                ];

                return Excel::download(new AttendanceByDateFormatDetail($data), $file_name);
            }
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[PROCESS]</b> failed :" . $e->getMessage()
            ]);
        }

        return null;
    }

    private function loadAttendancesFormatDetail(): \Illuminate\Database\Eloquent\Builder
    {
        $attendances = Attendance::with(
            'absentType', 'department', 'device', 'user', 'attachment'
        )->where('department_id', $this->department_id)->whereBetween('date', [
                Carbon::parse($this->from_date)->format('Y-m-d'),
                Carbon::parse($this->to_date)->format('Y-m-d')
        ]);

        if ((string) $this->absent_type_id !== 'ALL') {
            if (in_array($this->absent_type_id, [AbsentType::TANPA_KETERANGAN, AbsentType::CUTI, AbsentType::SAKIT])) {
                $attendances->where('absent_type_id', $this->absent_type_id);
            } else {
                $attendances->where('status', $this->absent_type_id);
            }
        }

        $attendances->orderBy('date', 'DESC');

        return $attendances;
    }

    private function loadAttendancesFormatTotal(): \Illuminate\Database\Eloquent\Builder
    {
        return Profile::with('department:id,name')
            ->where('department_id', $this->department_id)
            ->with([
                'user' => function($query) {
                    $query->withCount([
                    'attendances',
                    'attendances as attend_count' => function ($query) {
                        $query->where('status', 'ATTEND');
                    },
                    'attendances as attend_overdue_count' => function ($query) {
                        $query->where('status', 'ATTEND')->where('overdue', 1);
                    },
                    'attendances as attend_overtime_count' => function ($query) {
                        $query->where('status', 'ATTEND')->where('overtime', 1);
                    },
                    'attendances as absent_count' => function ($query) {
                        $query->where('status', 'ABSENT');
                    },
                    'attendances as absent_sick_count' => function ($query) {
                        $query->where('status', 'ABSENT')->where('absent_type_id', AbsentType::SAKIT);
                    },
                    'attendances as absent_leave_count' => function ($query) {
                        $query->where('status', 'ABSENT')->where('absent_type_id', AbsentType::CUTI);
                    },
                    'attendances as absent_missing_count' => function ($query) {
                        $query->where('status', 'ABSENT')->where('absent_type_id', AbsentType::TANPA_KETERANGAN);
                    }
                ])->orderBy('name', 'DESC');
            },
        ]);
    }
}
