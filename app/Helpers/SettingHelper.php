<?php

use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

if (! function_exists('app_settings')) {
    function app_settings()
    {
        if (Schema::hasTable('settings')) {
            return to_assoc_array(Setting::all());
        }

        return false;
    }
}

if (! function_exists('dif_for_human')) {
    // use this function to show currently logged in time
    // to user in local time and language
    function dif_for_human($date)
    {
        $diff = $date->diffForHumans();

        return str_replace(
            ["hour", "hours", "minute", "minutes", "seconds", "seconds", "ago"],
            ["Jam", "Jam", "Menit", "Menit", "Detik", "Detik", "lalu"],
            $diff
        );
    }
}

if (! function_exists('current_greeting')) {
    // use this function to return greeting message on user
    // in realtime with Carbon date and time library
    function current_greeting(): string
    {
        $hour = Carbon::now()->format('H');
        if ($hour < 11) return 'Selamat Pagi';
        if ($hour < 13) return 'Selamat Siang';
        if ($hour < 17) return 'Selamat Sore';
        return 'Selamat Malam';
    }
}

if (!function_exists('get_timezone')) {
    function get_timezone($ina_zone)
    {
        $timezone = 'Asia/Makassar';

        switch ($ina_zone) {
            case "WIT":
                $timezone = 'Asia/Jayapura';
                break;
            case "WIB":
                $timezone = 'Asia/Jakarta';
                break;
            case "WITA":
                $timezone = 'Asia/Makassar';
                break;
        }

        return $timezone;
    }
}

if (!function_exists('get_locale_time')) {
    function get_locale_time($inazone): object
    {
        $timezone = get_timezone($inazone);
        $current_time = \Illuminate\Support\Carbon::now($timezone);

        return (object) [
            'inazone' => $inazone,
            'timezone' => $timezone,
            'datetime' => $current_time->format('Y-m-d H:i:s'),
            'date' => $current_time->format('Y-m-d'),
            'time' => $current_time->format('H:i'),
            'timestamp' => $current_time->timestamp
        ];
    }
}

if (!function_exists('department_data')) {
    function department_data($department_id) {
        return \App\Models\Department::select('id', 'name')
            ->first($department_id);
    }
}
