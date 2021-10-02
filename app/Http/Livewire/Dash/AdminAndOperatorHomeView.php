<?php

namespace App\Http\Livewire\Dash;

use Livewire\Component;

class AdminAndOperatorHomeView extends Component
{
    public $member_count = 2;
    public $device_count = 4;
    public $attendance_count = 4;

    public $latest_activities = [
        [
            'name' => 'Bacdoor Kosong Dua',
            'attend' => 'out',
            'attend_time' => '02-10-2021 18:32',
            'status' => 'ontime',
        ],
        [
            'name' => 'Bacdoor Kosong Tiga',
            'attend' => 'out',
            'attend_time' => '02-10-2021 18:32',
            'status' => 'ontime',
        ],
        [
            'name' => 'Bacdoor Kosong Lima',
            'attend' => 'out',
            'attend_time' => '02-10-2021 17:32',
            'status' => 'ontime',
        ],
        [
            'name' => 'Bacdoor Kosong Satu',
            'attend' => 'out',
            'attend_time' => '02-10-2021 15:00',
            'status' => 'late',
        ],
        [
            'name' => 'Bacdoor  Kosong Lima',
            'attend' => 'in',
            'attend_time' => '02-10-2021 07:32',
            'status' => 'ontime',
        ],
        [
            'name' => 'Bacdoor Kosong Dua',
            'attend' => 'in',
            'attend_time' => '02-10-2021 08:00',
            'status' => 'ontime',
        ],
        [
            'name' => 'Bacdoor Kosong Tiga',
            'attend' => 'in',
            'attend_time' => '02-10-2021 07:20',
            'status' => 'ontime',
        ],
        [
            'name' => 'Bacdoor Kosong Satu',
            'attend' => 'in',
            'attend_time' => '02-10-2021 08:30',
            'status' => 'late',
        ],
    ];


    public function render()
    {
        return view('livewire.dash.admin-and-operator-home-view');
    }
}
