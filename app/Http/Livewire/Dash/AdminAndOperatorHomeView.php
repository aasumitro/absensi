<?php

namespace App\Http\Livewire\Dash;

use App\Models\Department;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DB;
use Livewire\Component;

class AdminAndOperatorHomeView extends Component
{
    public $department_timezone;

    public $member_count;

    public $device_count;

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

    protected $queryString = ['start_of_the_week', 'end_of_the_week'];

    public function mount()
    {
        $this->department_timezone = auth()->user()->profile->department->timezone->locale;
        $this->now = Carbon::now($this->department_timezone);
        $this->start_of_the_week = $this->now->startOfWeek(CarbonInterface::MONDAY)->format('d');
        $this->end_of_the_week = $this->now->endOfWeek(CarbonInterface::FRIDAY)->format('d');

        $department = Department::withCount(
            'members', 'devices', 'attendances'
        )->find(auth()->user()->profile->department_id);

        $this->member_count = $department->members_count;
        $this->device_count = $department->devices_count;
        $this->attendance_count = $department->attendances_count;

        $this->buildChartData($department->id);
    }

    public function render()
    {
        return view('livewire.dash.admin-and-operator-home-view');
    }

    private function buildChartData($department_id)
    {
        $this->labels = [
            "SENIN ($this->start_of_the_week)",
            "SELASA (".($this->start_of_the_week + 1).")",
            "RABU (".($this->start_of_the_week + 2).")",
            "KAMIS (".($this->start_of_the_week + 3).")",
            "JUMAT ($this->end_of_the_week)",
        ];

        $data = $this->latest_activities = DB::table('observe_attendances')
            ->whereBetween('date', [
                    $this->now->startOfWeek(CarbonInterface::MONDAY)->format('Y-m-d'),
                    $this->now->endOfWeek(CarbonInterface::FRIDAY)->format('Y-m-d')
            ])->where('department_id', $department_id);
        $this->latest_activities = $data->limit(8)->orderBy('date', 'DESC')->get();

        $data_all = $data->get();
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
            $current_itration_date = $this->start_of_the_week+$i;
            $absent[] = count(array_filter($data_all->toArray(), function($item) use($current_itration_date) {
                return $item->type === 'ABSENT' && $item->date === $this->now->format('Y-m-').$current_itration_date;
            }));
            $in[] = count(array_filter($data_all->toArray(), function($item) use($current_itration_date) {
                return $item->type === 'IN' && $item->date === $this->now->format('Y-m-').$current_itration_date;
            }));
            $out[] = count(array_filter($data_all->toArray(), function($item) use($current_itration_date) {
                return $item->type === 'OUT' && $item->date === $this->now->format('Y-m-').$current_itration_date;
            }));
            $i++;
        }

        $this->series = [$in, $out, $absent];
    }
}
