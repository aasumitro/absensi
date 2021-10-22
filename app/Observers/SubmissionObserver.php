<?php

namespace App\Observers;

use App\Models\Submission;
use Carbon\Carbon;

class SubmissionObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\Submission  $submission
     * @return void
     */
    public function created(Submission $submission)
    {
        \DB::table('observe_submissions')->insert([
            'submission_id' => $submission->id,
            'department_id' => $submission->department_id,
            'user_id' => $submission->user_id,
            'datetime' => Carbon::now('Asia/Makassar'),
            'data' => json_encode([
               'name' => $submission->user->name,
               'department' => $submission->department->name,
               'description' => "Membuat pengajuan IZIN baru  " .
                   $submission->absentType->description . " pada tanggal:" . $submission->start_at.
                   " sampai" . $submission->end_at
            ]),
            'created_at' => Carbon::now('Asia/Makassar'),
            'updated_at' => Carbon::now('Asia/Makassar')
        ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\Submission  $submission
     * @return void
     */
    public function updated(Submission $submission)
    {
        \DB::table('observe_submissions')
            ->where('submission_id', $submission->id)
            ->delete();
    }
}
