<?php

namespace App\Http\Livewire\Dash;

use App\Models\Managers\SettingManager;
use Livewire\Component;

class SettingMobileRemoteConfig extends Component
{
    use SettingManager;

    protected int $cache_time = 120;

    public $mobile_release_version;

    public $mobile_code_version;

    protected $listeners = ['remoteConfigSectionRefresh' => '$refresh'];

    public function mount()
    {
        $mobile_setting = $this->filter('mobile');

        foreach ($mobile_setting as $setting) {
            if ($setting->key === 'mobile_release_version'){
                $this->mobile_release_version = $setting->value;
            }

            if ($setting->key === 'mobile_code_version'){
                $this->mobile_code_version = $setting->value;
            }
        }
    }

    public function render()
    {
        return view('livewire.dash.setting-mobile-remote-config', [
            'settings' => $this->filter('mobile')
        ]);
    }

    public function performUpdate()
    {
        try {
            $data = $this->validate([
                'mobile_code_version' => 'required',
                'mobile_release_version' => 'required'
            ]);

            $this->modifySetting($data);

            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'success',
                'message' => "Action <b>[UPDATE]</b> success"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showNotify', [
                'type' => 'error',
                'message' => "Action <b>[UPDATE]</b> failed"
            ]);
        }

        $this->emit('remoteConfigSectionRefresh');
    }
}
