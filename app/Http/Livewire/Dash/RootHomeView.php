<?php

namespace App\Http\Livewire\Dash;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\User;
use Carbon\CarbonInterface;
use DB;
use Illuminate\Support\Carbon;
use Livewire\Component;

class RootHomeView extends Component
{
    public $department_count;

    public $member_count;

    public $attendance_count;

    public $latest_activities;

    public $now;

    public $start_of_the_week;

    public $end_of_the_week;

    public array $labels;

    public array $series;

    public $in_count;

    public $out_count;

    public $absent_count;

    public $pie_chart_status_attend;
    public $pie_chart_status_absent;
    public $pie_chart_status_series;

    public $pie_chart_type_qrscan;
    public $pie_chart_type_qrgen;
    public $pie_chart_type_picture;
    public $pie_chart_type_system;
    public $pie_chart_type_series;

    public $pie_chart_absent_type_ct;
    public $pie_chart_absent_type_sk;
    public $pie_chart_absent_type_tk;
    public $pie_chart_absent_type_series;

    protected $queryString = [
        'start_of_the_week',
        'end_of_the_week'
    ];

    public function mount()
    {
        $this->now = Carbon::now(`Asia/Makassar`);

        $this->start_of_the_week = $this->now->startOfWeek(CarbonInterface::MONDAY)->format('d');
        $this->end_of_the_week = $this->now->endOfWeek(CarbonInterface::FRIDAY)->format('d');

        $this->department_count = Department::all()->count();
        $this->member_count = User::all()->count();
        $attendance = Attendance::with('absentType');
        $this->attendance_count = $attendance->get()->count();
        $attendance_between = $attendance->whereBetween('date', [
            $this->now->startOfWeek(CarbonInterface::MONDAY)->format('Y-m-d'),
            $this->now->endOfWeek(CarbonInterface::FRIDAY)->format('Y-m-d')
        ]);
        $attendance_all = $attendance_between->get();
        $attendance_type_absent = $attendance_between->where('status', 'ABSENT')->get();
        // START_PIE_CHART

        $this->pie_chart_status_attend = count(array_filter($attendance_all->toArray(), function($item) {
            return $item['status'] === 'ATTEND';
        }));
        $this->pie_chart_status_absent = count(array_filter($attendance_all->toArray(), function($item) {
            return $item['status'] === 'ABSENT';
        }));
        $this->pie_chart_status_series = [
            $this->pie_chart_status_attend,
            $this->pie_chart_status_absent
        ];

        $this->pie_chart_type_qrscan = count(array_filter($attendance_all->toArray(), function($item) {
            return $item['type'] === 'QRCODE_SCAN';
        }));
        $this->pie_chart_type_qrgen = count(array_filter($attendance_all->toArray(), function($item) {
            return $item['type'] === 'QRCODE_GEN';
        }));
        $this->pie_chart_type_picture = count(array_filter($attendance_all->toArray(), function($item) {
            return $item['type'] === 'PICTURE';
        }));
        $this->pie_chart_type_system = count(array_filter($attendance_all->toArray(), function($item) {
            return $item['type'] === 'NONE';
        }));
        $this->pie_chart_type_series = [
            $this->pie_chart_type_qrscan,
            $this->pie_chart_type_qrscan,
            $this->pie_chart_type_picture,
            $this->pie_chart_type_system
        ];

        $this->pie_chart_absent_type_ct = count(array_filter($attendance_type_absent->toArray(), function($item) {
            return $item['absentType']['name'] === 'CT';
        }));
        $this->pie_chart_absent_type_sk = count(array_filter($attendance_type_absent->toArray(), function($item) {
            return $item['absentType']['name'] === 'SK';
        }));
        $this->pie_chart_absent_type_tk = count(array_filter($attendance_type_absent->toArray(), function($item) {
            return $item['absentType']['name'] === 'TK';
        }));
        $this->pie_chart_absent_type_series = [
            $this->pie_chart_absent_type_ct,
            $this->pie_chart_absent_type_sk,
            $this->pie_chart_absent_type_tk
        ];
        // END_PIE_CHART


        // START_CHART_RANKING
        $this->labels = [
            "SENIN ($this->start_of_the_week)",
            "SELASA (".($this->start_of_the_week + 1).")",
            "RABU (".($this->start_of_the_week + 2).")",
            "KAMIS (".($this->start_of_the_week + 3).")",
            "JUMAT ($this->end_of_the_week)",
        ];
        $data = DB::table('observe_attendances')->whereBetween('date', [
            $this->now->startOfWeek(CarbonInterface::MONDAY)->format('Y-m-d'),
            $this->now->endOfWeek(CarbonInterface::FRIDAY)->format('Y-m-d')
        ]);
        $data_all = $data->get();
        $this->latest_activities = $data->limit(8)->orderBy('date', 'DESC')->get();
        $this->in_count = count(array_filter($data_all->toArray(), function($item) {
            return $item->type === 'IN';
        }));
        $this->out_count = count(array_filter($data_all->toArray(), function($item) {
            return $item->type === 'OUT';
        }));
        $this->absent_count = count(array_filter($data_all->toArray(), function($item) {
            return $item->type === 'ABSENT';
        }));
        $absent = []; $in = []; $out = [];
        $i = 0;
        foreach ($this->labels as $label) {
            $current_iteration_date = $this->start_of_the_week+$i;
            $absent[] = count(array_filter($data_all->toArray(), function($item) use($current_iteration_date) {
                return $item->type === 'ABSENT' && $item->date === $this->now->format('Y-m-').$current_iteration_date;
            }));
            $in[] = count(array_filter($data_all->toArray(), function($item) use($current_iteration_date) {
                return $item->type === 'IN' && $item->date === $this->now->format('Y-m-').$current_iteration_date;
            }));
            $out[] = count(array_filter($data_all->toArray(), function($item) use($current_iteration_date) {
                return $item->type === 'OUT' && $item->date === $this->now->format('Y-m-').$current_iteration_date;
            }));
            $i++;
        }
        $this->series = [$in, $out, $absent];
        // END_CHART_RANKING
    }

    public function render()
    {
        return view('livewire.dash.root-home-view');
    }
}
