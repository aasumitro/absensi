<?php

namespace App\Http\Livewire\Dash;

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

    public $attachment;

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
            'preferences' => $this->fetchPreferences()
        ]);
    }

    public function selectedPreferences(MobilePreference $preference, $type, $action)
    {
        $this->dispatchBrowserEvent(
            'openModal',
            ['type' => $action]
        );

        $this->selected_id = $preference->id;
        $this->title = $preference->title;
        $this->description = $preference->description;
        $this->live_date_show = strftime(
            '%Y-%m-%dT%H:%M',
            strtotime($preference->live_date_show));
        $this->live_date_hide = strftime(
            '%Y-%m-%dT%H:%M',
            strtotime($preference->live_date_hide));
        $this->type = $preference->type;
        $this->popup = $preference->popup;
        $this->banner = $preference->banner;
        $this->status = $preference->status;

        if ($type === 'SLIDER') {
            $this->attachment = $preference->attachment;
        }
    }

    public function performUpdate()
    {
        try {
            $data = $this->validate();

            if ($this->live_date_show !== null) {
                $data['live_date_show'] =  strftime(
                    '%Y-%m-%d %H:%I:%S',
                    strtotime($this->live_date_show));
            }

            if ($this->live_date_hide !== null) {
                $data['live_date_hide'] = strftime(
                    '%Y-%m-%d %H:%I:%S',
                    strtotime($this->live_date_hide));
            }

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
            ['type' => 'UPDATE']
        );

        $this->emit('mobilSliderSectionRefresh');
    }
}
