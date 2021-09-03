<?php

namespace App\Models\Managers;

use App\Models\MobilePreference;
use Illuminate\Support\Facades\Cache;

trait MobilePreferencesManager
{
    private string $fetch_mobile_preference_key = 'livewire_trait_mobile_preference_list';

    public function fetchPreferences()
    {
        return Cache::remember($this->fetch_mobile_preference_key, $this->cache_time, function () {
            return MobilePreference::with('attachment')->get();
        });
    }

    public function modifyPreference($id, $data)
    {
        MobilePreference::findOrFail($id)->update($data);

        Cache::forget($this->fetch_mobile_preference_key);
    }
}
