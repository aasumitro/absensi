<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notification extends Component
{
    public $notifications;

    public function mount()
    {
        $this->loadSubmissionNotification();
    }

    public function render()
    {
        return view('livewire.notification');
    }

    private function loadSubmissionNotification()
    {
        $this->notifications = \DB::table('observe_submissions')
            ->limit(3)
            ->get();
    }
}
