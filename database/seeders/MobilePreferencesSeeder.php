<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobilePreferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attachments')->insert( [
            'name' => 'slider-default.png',
            'path' => 'images/mobile',
            'type' => 'IMAGE',
        ]);

        DB::table('mobile_preferences')->insert([
            [
                'attachment_id' => 1,
                'title' => 'TEST_ONE',
                'description' => "TEST_ONE_DESCRIPTION",
                'type' => "SLIDER",
                'status' => "HIDE",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'attachment_id' => 1,
                'title' => 'TEST_TWO',
                'description' => "TEST_TWO_DESCRIPTION",
                'type' => "SLIDER",
                'status' => "HIDE",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'attachment_id' => 1,
                'title' => 'ANNOUNCEMENT_ONE',
                'description' => "ANNOUNCEMENT_ONE_DESCRIPTION",
                'type' => "ANNOUNCEMENT",
                'status' => "HIDE",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
