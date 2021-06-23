<?php

namespace App\Http\Livewire\Dash;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class UserAccountList extends Component
{
    use WithPagination;

    private array $hide_by_role = [4];

    private int $cache_in_second = 120;

    protected $listeners = ['accountListSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.user-account-list', [
            'users' => $this->fetchUserAccounts()
        ]);
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
