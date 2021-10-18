<?php

namespace App\Actions;

use App\Models\Attendance;
use App\Models\Device;
use Carbon\Carbon;

class AttendanceFromFile
{
    public function execute(array $attendances)
    {
        $apply_filter = array_filter($attendances, function($item) {
            return !is_string($item['username']);
        });

        $device = Device::select('id', 'department_id', 'display')
            ->where([
                'display' => 'DASHBOARD',
                'department_id' => auth()->user()->profile->department_id
            ])->firstOrFail();


        foreach ($apply_filter as $data) {
            $time_in = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                "{$data['date']} {$data['time_in']}:00"
            );

            $time_out = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                "{$data['date']} {$data['time_out']}:00"
            );

            Attendance::create([
                'user_id' => $data['username']['id'],
                'device_id' => $device->id,
                'department_id' => $device->department_id,
                'type' => 'NONE',
                'status' => 'ATTEND',
                'date' => $data['date'],
                'datetime_in' => $time_in,
                'datetime_out' => $time_out,
                'timestamp_in' => $time_in->timestamp,
                'timestamp_out' => $time_out->timestamp,
                'overdue' => ($data['overdue'] === 'YA' ? 1 : 0),
                'overtime' => ($data['overtime'] === 'YA' ? 1 : 0),
                'by' => 'ADMIN/OPERATOR'
            ]);
        }
    }
}
