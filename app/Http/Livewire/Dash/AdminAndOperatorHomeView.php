<?php

namespace App\Http\Livewire\Dash;

use App\Models\Department;
use Livewire\Component;

class AdminAndOperatorHomeView extends Component
{
    public $member_count;

    public $device_count;

    public $attendance_count;

    public $latest_activities;

    public $now;

    public array $labels;

    public array $series;

    public $in_count;

    public $out_count;

    public $absent_count;

    public function mount()
    {
        $department = Department::withCount(
            'members', 'devices', 'attendances'
        )->find(auth()->user()->profile->department_id);

        $this->member_count = $department->members_count;
        $this->device_count = $department->devices_count;
        $this->attendance_count = $department->attendances_count;

        $this->latest_activities = \DB::table('observe_attendances')
            ->where('department_id', $department->id)
            ->limit(8)
            ->get();

        $this->now = \Carbon\Carbon::now();
        $startDate = $this->now->startOfWeek(\Carbon\Carbon::MONDAY)->format('d');
        $endDate = $this->now->endOfWeek(\Carbon\Carbon::FRIDAY)->format('d');
        $this->labels = ["SENIN ($startDate)",
            "SELASA (".($startDate + 1).")",
            "RABU (".($startDate + 2).")",
            "KAMIS (".($startDate + 3).")",
            "JUMAT ({$endDate})",
        ];
        $this->series = [[1, 2, 3, 4, 5], [1, 2, 3, 4, 5], [1, 2, 3, 4, 5]];
        $this->in_count = 15;
        $this->out_count = 15;
        $this->absent_count = 15;
    }

    public function render()
    {
        return view('livewire.dash.admin-and-operator-home-view');
    }
}
