<?php

namespace App\Http\Livewire\Dash\Staff;

use App\Models\AbsentType;
use App\Models\Submission;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class StaffAttendanceVerifySubmission extends Component
{
    use WithPagination;

    protected $submission_data;

    public $submission_selected_id;

    public $status;

    public $from_date;

    public $to_date;

    public $absent_type_id;

    public $department_id;

    public $update_status;

    public $update_notes;

    public $page = 1;

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
        $this->to_date = Carbon::now()->format('Y-m-d');
        $this->from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->department_id = auth()->user()->profile->department_id;
        $this->status = 'ISSUED';
        $this->absent_type_id = 'ALL';
        $this->update_status = "ACCEPTED";
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

    }

    public function performUpdateSubmission()
    {
        $data = $this->validateRequestData();

        try {
            Submission::where(
                'id', $this->submission_selected_id
            )->update($data);

            // TODO add new Attendance after (ACCEPTED)

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (\Exception $e) {
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

    private function loadSubmissions(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $submissions = Submission::with('absentType', 'user')
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
}
