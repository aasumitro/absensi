<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Models\AbsentType;
use App\Models\Attendance;
use App\Models\Device;
use App\Models\Managers\AttachmentManager;
use App\Models\Submission;
use App\Models\User;
use App\Notifications\TelegramAttendNotification;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StaffAttendanceVerifySubmission extends Component
{
    use WithPagination, WithFileUploads, AttachmentManager;

    protected $submission_data;

    public $submission_selected_id;

    public $status;

    public $from_date;

    public $to_date;

    public $absent_type_id;

    public $absent_type;

    public $department_id;

    public $update_status;

    public $update_notes;

    public $default_device;

    public $page = 1;

    /// [START] ADD NEW SUBMISSION FORM
    public $query;

    public $selected_user;

    public $users;

    public $title;

    public $description;

    public $date_start;

    public $date_end;

    public $file;
    /// [END] ADD NEW SUBMISSION FORM

    public $submission_total;
    public $submission_process_total;
    public $submission_accepted_total;
    public $submission_rejected_total;

    protected $queryString = [
        'status',
        'from_date',
        'to_date',
        'absent_type_id',
        'page' => ['except' => 1],
    ];

    protected $listeners = ['staffSubmissionSectionRefresh' => '$refresh'];

    public function mount()
    {
        $this->to_date = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->department_id = auth()->user()->profile->department_id;
        $this->status = 'ALL';
        $this->absent_type_id = 'ALL';
        $this->absent_type = 1;
        $this->update_status = "ACCEPTED";
        $this->default_device = Device::where([
            'department_id' => $this->department_id,
            'display' => "DASHBOARD"
        ])->first()->id;

        $submissions = Submission::all();
        $this->submission_total = $submissions->count();
        $this->submission_process_total = count(array_filter(
            $submissions->toArray(),
            function($item) {
                return $item['status'] === 'ISSUED';
            }));
        $this->submission_accepted_total = count(array_filter(
            $submissions->toArray(),
            function($item) {
                return $item['status'] === 'ACCEPTED';
            }));
        $this->submission_rejected_total = count(array_filter(
            $submissions->toArray(),
            function($item) {
                return $item['status'] === 'REJECTED';
            }));
    }

    public function render()
    {
        return view('livewire.dash.staff.staff-attendance-verify-submission', [
            'absentTypes' => AbsentType::all(),
            'submissions' => $this->loadSubmissions()
        ]);
    }

    public function selectedSubmission(Submission $submission, $action)
    {
        $this->submission_selected_id = $submission->id;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );
    }

    public function performAddSubmission()
    {
        $data = $this->validateNewSubmission();

        DB::beginTransaction();

        try {
            if ((int) $this->absent_type !== AbsentType::TANPA_KETERANGAN) {
                if (substr($data['file']->getFileName(), -3) === 'pdf') {
                    $attachment = $this->newAttachment([
                        'type' => 'FILE',
                        'file'=> $data['file']
                    ], 'PRIVATE');
                }

                if (in_array(substr($data['file']->getFileName(), -3), ['jpg','png','jpeg'])) {
                    $attachment = $this->newAttachment([
                        'type' => 'IMAGE',
                        'file'=> $data['file']
                    ], 'PRIVATE');
                }

                unset($data['file']);
                $data['attachment_id'] = $attachment->id ?? null;
            }

            $submission = Submission::create($data);

            $this->validSubmission($submission);

            DB::commit();

            $user = User::find($submission->user_id);
            if ($user->telegram_id) {
                $user->notify(new TelegramAttendNotification(
                    "Pengajuan izin anda untuk tanggal " .
                    "$submission->start_at sampai $submission->end_at".
                    " telah dibuat dan diterima oleh " . auth()->user()->name
                ));
            }

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (Exception $exception) {
            DB::rollback();

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed :" . $exception->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'CREATE']
        );

        $this->emit('staffSubmissionSectionRefresh');

        $this->reset(['selected_user', 'title', 'description', 'date_start', 'date_end']);
    }

    public function performUpdateSubmission()
    {
        $data = $this->validateRequestData();

        DB::beginTransaction();

        try {
            $submission = Submission::where(
                'id', $this->submission_selected_id
            )->first();

            if ($data['status'] === 'ACCEPTED') {
                $this->validSubmission($submission);
            }

            $submission->update($data);

            DB::commit();

            $user = User::find($submission->user_id);
            if ($user->telegram_id) {
                $status = ($data['status'] === 'ACCEPTED') ? 'diterima' : 'ditolak';
                $notes = ($data['status'] === 'ACCEPTED') ? ''
                    : " dengan alasan {$data['notes']}, silahkan mengirimkan pengajuan izin kembali!";

                $user->notify(new TelegramAttendNotification(
                    "Pengajuan izin anda untuk tanggal " .
                    "$submission->start_at sampai $submission->end_at".
                    " telah $status oleh " . auth()->user()->name .
                    $notes
                ));
            }

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (Exception $e) {
            DB::rollback();

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed :" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'UPDATE']
        );

        $this->emit('staffSubmissionSectionRefresh');
    }

    public function selectUser(User $user)
    {
        $this->query = null;

        if ($user->profile->department->id === $this->department_id) {
            $this->selected_user = $user ?? null;
        } else {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => 'Anda tidak dapat memilih pegawai dari SKPD lain'
            ]);
        }
    }

    public function updatedQuery()
    {
        $this->users = User::where('name', 'like', '%' . $this->query . '%')
            ->with('profile.department:id,name')
            ->whereHas('profile.department', function ($query) {
                $query->where('id', $this->department_id);
            })->get();
    }

    private function validateRequestData(): array
    {
        $data = [];

        if ($this->update_status === 'ACCEPTED') {
            $validatedData = $this->validate([
                'update_status' => 'required'
            ]);

            $data = [
                'status' => $validatedData['update_status']
            ];
        }

        if ($this->update_status === 'REJECTED') {
            $validatedData = $this->validate([
                'update_status' => 'required',
                'update_notes' => 'required'
            ]);

            $data = [
                'status' => $validatedData['update_status'],
                'notes' => $validatedData['update_notes'],
            ];
        }

        return $data;
    }

    private function validateNewSubmission(): array
    {
        if ((int)$this->absent_type === AbsentType::TANPA_KETERANGAN) {
            $validatedData = $this->validate([
                'absent_type' => 'required',
                'title' => 'required',
                'description' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
            ]);
        } else {
            $validatedData = $this->validate([
                'absent_type' => 'required',
                'title' => 'required',
                'description' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
                'file' => "file|mimes:pdf,jpg,png,jpeg"
            ]);
        }

        $validatedData['absent_type_id'] = $validatedData['absent_type'];
        $validatedData['user_id'] = $this->selected_user->id;
        $validatedData['start_at'] = $validatedData['date_start'];
        $validatedData['end_at'] = $validatedData['date_end'];
        $validatedData['status'] = 'ACCEPTED';
        $validatedData['department_id'] = $this->department_id;

        unset(
            $validatedData['date_start'],
            $validatedData['date_end'],
            $validatedData['absent_type']
        );

        return  $validatedData;
    }

    private function loadSubmissions(): LengthAwarePaginator
    {
        $submissions = Submission::with('absentType', 'user', 'attachment')
            ->where('created_at', '>=',  Carbon::parse($this->from_date)->format('Y-m-d 00:00:00'))
            ->where('created_at', '<=',  Carbon::parse($this->to_date)->format('Y-m-d 23:59:59'));

        if ((string)$this->status !== 'ALL') {
            $submissions->where('status', $this->status);
        }

        if ((string)$this->absent_type_id !== 'ALL') {
            $submissions->where('absent_type_id', $this->absent_type_id);
        }

        return $submissions->paginate(10);
    }

    private function validSubmission(Submission $submission)
    {
        $period = CarbonPeriod::create($submission->start_at, $submission->end_at);
        error_log($period);
        foreach ($period as $date) {
            Attendance::create([
                'user_id' => $submission->user_id,
                'absent_type_id' => $submission->absent_type_id,
                'device_id' => $this->default_device,
                'department_id' => $submission->department_id,
                'attachment_id' => $submission->attachment_id,
                'date' => $date->format('Y-m-d'),
                'type' => 'NONE',
                'status' => 'ABSENT',
                'by' => 'ADMIN/OPERATOR'
            ]);
        }
    }
}
