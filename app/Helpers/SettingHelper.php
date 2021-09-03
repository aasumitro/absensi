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
