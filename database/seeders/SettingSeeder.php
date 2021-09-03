<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
               'value' => 'OkSetda Absensi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'key' => 'app_desc',
                'value' => 'Electronic Attendance Server Platform',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'key' => 'app_version',
                'value' => 'v0.1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'key' => 'app_favicon',
                'value' => 'favicon.ico',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'key' => 'app_logo',
                'value' => 'logo.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'key' => 'app_analytics_id',
                'value' => 'NOT_SET',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'key' => 'app_maintenance',
                'value' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'key' => 'mobile_code_version',
                'value' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'key' => 'mobile_release_version',
                'value' => '0.1+dev',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
