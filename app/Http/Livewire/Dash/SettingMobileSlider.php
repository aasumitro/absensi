<?php

namespace App\Http\Livewire\Dash;

use App\Models\Attachment;
use App\Models\Managers\MobilePreferencesManager;
use App\Models\MobilePreference;
use Livewire\Component;

class SettingMobileSlider extends Component
{
    use MobilePreferencesManager;

    protected int $cache_time = 120;

    public $selected_id;

    public $title;

    public $description;

    public $live_date_show;

    public $live_date_hide;

    public $type;

    public $popup;

    public $banner;

    public $status;

    public $action_link;

    public $selected_attachment;

    public $attachment_id;

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'type' => 'required',
        'popup' => 'required',
        'banner' => 'required',
        'status' => 'required',
    ];

    protected $listeners = ['mobilSliderSectionRefresh' => '$refresh'];

    public function render()
    {
        return view('livewire.dash.setting-mobile-slider', [
            'preferences' => $this->fetchPreferences(),
            'attachments' => Attachment::where('type', 'IMAGE')->get()
        ]);
    }

    public function selectedPreferences(MobilePreference $preference, $type, $action)
    {
        $this->dispatchBrowserEvent(
            'openModal',
            ['action' => $action, 'type' => $type]
        );

        $this->selected_id = $preference->id;
        $this->title = $preference->title;
        $this->description = $preference->description;
        $this->live_date_show = $preference->live_date_show ? strftime(
            '%Y-%m-%dT%H:%M',
            strtotime($preference->live_date_show)) : null;
        $this->live_date_hide = $preference->live_date_hide ? strftime(
            '%Y-%m-%dT%H:%M',
            strtotime($preference->live_date_hide)) : null;
        $this->type = $preference->type;
        $this->popup = $preference->popup;
        $this->banner = $preference->banner;
        $this->status = $preference->status;

        if ($type === 'SLIDER') {
            $this->action_link = $preference->action_link ?: url('/');
            $this->selected_attachment = $preference->attachment;
            $this->attachment_id = $preference->attachment->id;
        }
    }

    public function clearData($variable)
    {
        if ($variable === 'date_show') {
            $this->live_date_show = null;
        }

        if ($variable === 'date_hide') {
            $this->live_date_hide = null;
        }
    }

    public function performUpdate()
    {
        try {
            $data = $this->validate();

            $data['action_link'] = $this->action_link;
            $data['attachment_id'] = $this->attachment_id;
            $data['live_date_show'] = $this->live_date_show ? strftime(
                '%Y-%m-%d %H:%I:%S',
                strtotime($this->live_date_show)) : null;

            $data['live_date_hide'] = $this->live_date_hide ? strftime(
                '%Y-%m-%d %H:%I:%S',
                strtotime($this->live_date_hide)) : null;

            $this->modifyPreference($this->selected_id, $data);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed" . $e->getMessage()
            ]);
        }

        $this->dispatchBrowserEvent(
            'closeModal',
            ['action' => 'UPDATE', 'type' => $this->type]
        );

        $this->emit('mobilSliderSectionRefresh');
    }
}
