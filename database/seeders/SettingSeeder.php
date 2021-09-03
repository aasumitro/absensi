<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
               'key' => 'app_name',
               'value' => 'OkSetda Absensi'
            ],
            [
                'key' => 'app_desc',
                'value' => 'Electronic Attendance Server Platform'
            ],
            [
                'key' => 'app_version',
                'value' => 'v0.1'
            ],
            [
                'key' => 'app_favicon',
                'value' => 'favicon.ico'
            ],
            [
                'key' => 'app_logo',
                'value' => 'logo.png'
            ],
            [
                'key' => 'app_analytics_id',
                'value' => 'NOT_SET'
            ],
            [
                'key' => 'app_maintenance',
                'value' => false
            ],
            [
                'key' => 'mobile_code_version',
                'value' => '1'
            ],
            [
                'key' => 'mobile_release_version',
                'value' => '0.1+dev'
            ],
        ]);
    }
}
