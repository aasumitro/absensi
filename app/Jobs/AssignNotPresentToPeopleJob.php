<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignNotPresentToPeopleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TODO:
        // Running Job at Next Day + 1 (01:00 AM)
        // Check All Users Attendance
        // IF NULL at The Day
        // Add New Attendance with Absent Type #3 TANPA_KETERANGAN

        // FILL THE FORM:
        // by = SYSTEM
        // USER_ID (REQUIRED)
        // absent_type_id = 3
        // device_id = DEFAULT[DASHBOARD]
        // department_id = user_department_id
        // type = NONE
        // status = ABSENT
        // date = CURRENT_SELECTED_DATE
    }
}
