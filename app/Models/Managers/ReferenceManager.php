<?php

namespace App\Models\Managers;

use App\Models\AbsentType;
use App\Models\MobilePreference;
use Illuminate\Support\Facades\Cache;

trait ReferenceManager
{
    private string $fetch_absent_type_key = 'api_mobile_absent_type_list';

    private string $fetch_announcement_key = 'api_mobile_announcement_list';

    private string $fetch_slider_key = 'api_mobile_slider_list';

    private int $cache_time = 120;

    protected function fetchAbsentTypes()
    {
        return Cache::remember($this->fetch_absent_type_key, $this->cache_time, function ()
        {
            return AbsentType::all();
        });
    }

    protected function fetchAnnouncements()
    {
        return Cache::remember($this->fetch_announcement_key, $this->cache_time, function ()
        {
            return  MobilePreference::where([
                'type' => 'ANNOUNCEMENT',
                'status' => 'SHOW'
            ])->with('attachment')->get();
        });
    }

    protected function fetchSliders()
    {
        return Cache::remember($this->fetch_slider_key, $this->cache_time, function ()
        {
            return  MobilePreference::where([
                'type' => 'SLIDER',
                'status' => 'SHOW'
            ])->with('attachment')->get();
        });
    }
}
