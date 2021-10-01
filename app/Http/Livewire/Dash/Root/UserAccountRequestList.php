<?php

namespace App\Http\Livewire\Dash\Root;

use App\Events\RequestAdminEvent;
use App\Models\Managers\AccountManager;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class UserAccountRequestList extends Component
{
    use WithPagination, AccountManager;

    public $selected_request_id;

    public $commit_by;

    public $status;

    public $user;

    protected $listeners = ['accountRequestSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.user-account-request-list', [
            'requests' => \DB::table('requests')
                ->where([
                    'type' => 'ADMIN_ACCOUNT',
                    'commit' => 'ISSUED'
                ])->paginate(10)
        ]);
    }

    public function setSelectedAccount($user, $request_id, $commit_by, string $status,  $action)
    {
        $this->user = $user;

        $this->selected_request_id = $request_id;

        $this->commit_by = $commit_by;

        $this->status = $status;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );
    }

    public function performConfirmRequest()
    {
        try {
            if ($this->status === 'EXIST') {
                $this->acceptExistAccount();
            }

            if ($this->status === 'NONE') {
                $this->acceptNewAccount();
            }

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[ACCEPT]</b> success"
            ]);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[ACCEPT]</b> failed :" . $exception->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'UPDATE']
        );

        $this->emit('accountRequestSectionRefresh');
    }

    private function acceptExistAccount(): int
    {
        $user = User::where([
            'username' => $this->user['username'],
            'email' => $this->user['email']
        ])->first();

        $user->role_id = ADMIN_ROLE_ID;
        $user->save();

        return $this->onRequestAccepted();
    }

    private function acceptNewAccount(): int
    {
        $this->newAccount([
            'as' => 'THL',
            'name' => $this->user['name'],
            'email' => $this->user['email'],
            'phone' => $this->user['phone'],
            'username' => $this->user['username'],
            'role' => $this->user['role'],
            'department' => $this->user['department_id']
        ]);

        return $this->onRequestAccepted();
    }

    private function onRequestAccepted(): int
    {
        event(new RequestAdminEvent(
            User::find($this->commit_by),
            'ADMIN_ACCOUNT_ACCEPT'
        ));

        return \DB::table('requests')
            ->where('id', $this->selected_request_id)
            ->update([
                'commit' => 'ACCEPTED',
                'recommit_by' => auth()->user()->id,
                'updated_at' => Carbon::now()
            ]);
    }
}
