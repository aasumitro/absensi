<?php

namespace App\Http\Livewire\Dash;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class UserAccountList extends Component
{
    use WithPagination;

    public $selected_id;

    private array $hide_by_role = [4];

    private int $cache_in_second = 120;

    protected $listeners = ['accountListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.user-account-list', [
            'users' => $this->fetchUserAccounts()
        ]);
    }

    public function selectedAccount(User $user, $action): void
    {
        $this->selected_id = $user->id;

        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );

//        if ($action === 'UPDATE') {
//            $this->type = $work_time->type;
//            $this->max_att_in = $work_time->max_att_in;
//            $this->min_att_out = $work_time->min_att_out;
//            $this->description = $work_time->description;
//            $this->next_day = $work_time->next_day;
//        }
    }

    public function performDestroy(int $user_id): void
    {
        try {
            User::destroy($user_id);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[DESTROY]</b> success"
            ]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[DESTROY]</b> failed"
            ]);
        }

        Cache::forget('users_account_without_member');


        $this->dispatchBrowserEvent(
            'closeModal',
            ['type' => 'DESTROY']
        );

        $this->emit('accountListSectionRefresh');
    }

    private function fetchUserAccounts()
    {
        return Cache::remember(
            'users_account_without_member',
            $this->cache_in_second, function ()
        {
            return User::with('profile.department', 'role')
                ->whereNotIn('role_id', $this->hide_by_role)
                ->paginate(10);
        });
    }
}
