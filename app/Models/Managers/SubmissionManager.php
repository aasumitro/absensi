<?php

namespace App\Models\Managers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

trait SubmissionManager
{
    /**
     * @throws \Exception
     */
    public function applyNewSubmission(Request $request): bool
    {
        $submission = Submission::where([
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ])->first();

        if ($submission) {
            throw new \Exception("Sepertinya Anda telah mengirimkan pengajuan untuk tanggal $request->start_at sampai $request->end_at sebelumnya");
        }

        $attachment_id = $this->uploadFile($request->file);

        $submission = Submission::create([
            'attachment_id' => $attachment_id,
            'absent_type_id' => $request->absent_type_id,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
            'department_id' => auth()->user()->profile->department_id,
        ]);

        return (bool)$submission;
    }

    private function uploadFile(UploadedFile $file)
    {
        if (substr($file->extension(), -3) === 'pdf') {
            $attachment = $this->newAttachment([
                'type' => 'FILE',
                'file'=> $file
            ], 'PRIVATE');
        }

        if (in_array(substr($file->extension(), -3), ['jpg','png','jpeg'])) {
            $attachment = $this->newAttachment([
                'type' => 'IMAGE',
                'file'=> $file
            ], 'PRIVATE');
        }

        return $attachment->id ?? null;
    }
}
