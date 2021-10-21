<?php

namespace App\Observers;

use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Attendance "created" event.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return void
     */
    public function created(Attendance $attendance)
    {
        if ($attendance->status === 'ATTEND') {
            if ($attendance->datetime_in) {
                \DB::table('observe_attendances')->insert([
                    'date'  => $attendance->date,
                    'datetime'  => $attendance->datetime_in,
                    'department_id' => $attendance->department_id,
                    'attendance_id' => $attendance->id,
                    'user_id' => $attendance->user_id,
                    'data' => $attendance->user->name,
                    'type' => 'IN',
                    'status' => ((int)$attendance->overdue === 0) ? 'ON_TIME' : 'OVERTIME',
                    'created_at' => Carbon::now('Asia/Makassar'),
                    'updated_at' => Carbon::now('Asia/Makassar')
                ]);
            }

            if ($attendance->datetime_out) {
                \DB::table('observe_attendances')->insert([
                    'date'  => $attendance->date,
                    'datetime'  => $attendance->datetime_out,
                    'department_id' => $attendance->department_id,
                    'attendance_id' => $attendance->id,
                    'user_id' => $attendance->user_id,
                    'data' => $attendance->user->name,
                    'type' => 'OUT',
                    'created_at' => Carbon::now('Asia/Makassar'),
                    'updated_at' => Carbon::now('Asia/Makassar')
                ]);
            }
        }

        if ($attendance->status === 'ABSENT') {
            \DB::table('observe_attendances')->insert([
                'date'  => $attendance->date,
                'datetime'  => $attendance->datetime_out,
                'department_id' => $attendance->department_id,
                'attendance_id' => $attendance->id,
                'user_id' => $attendance->user_id,
                'data' => $attendance->user->name,
                'type' => 'ABSENT',
                'type_detail' => strtoupper($attendance->absentType->description),
                'created_at' => Carbon::now('Asia/Makassar'),
                'updated_at' => Carbon::now('Asia/Makassar')
            ]);
        }
    }

    /**
     * Handle the Attendance "updated" event.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return void
     */
    public function updated(Attendance $attendance)
    {
        \DB::table('observe_attendances')->insert([
            'date'  => $attendance->date,
            'datetime'  => $attendance->datetime_out,
            'department_id' => $attendance->department_id,
            'attendance_id' => $attendance->id,
            'user_id' => $attendance->user_id,
            'data' => $attendance->user->name,
            'type' => 'OUT',
            'created_at' => Carbon::now('Asia/Makassar'),
            'updated_at' => Carbon::now('Asia/Makassar')
        ]);
    }
}
