<?php

namespace App\Models\Managers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

trait SettingManager
{
    private string $fetch_setting_key = 'livewire_trait_setting_list';

    private array $available_setting_data = ['mobile', 'app'];

    public function fetchSettings()
    {
        return Cache::remember($this->fetch_setting_key, $this->cache_time, function ()
        {
            return app_settings();
        });
    }

    public function filter($data): array
    {
        if (!in_array($data, $this->available_setting_data)) {
            throw (new \Exception('Selected settings not available'));
        }

        $filtered = [];

        foreach ($this->fetchSettings() as $key => $value) {
            $key_data = explode('_', $key);

            if ($key_data[0] === $data) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    public function modifySetting($data)
    {
        foreach ($data as  $key => $val) {
            $setting = Setting::where('key', $key)->first();

            if ($val !== null) {
                $setting->value = $val;
                $setting->save();
            }
        }

        Cache::forget($this->fetch_setting_key);
    }
}
