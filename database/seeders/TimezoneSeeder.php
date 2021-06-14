<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timezones')->insert([
            [
               'locale' => 'Asia/Jakarta',
               'title' => 'WIB',
               'description' => 'waktu indonesia bagian barat (UTC+7)',
            ],
            [
                'locale' => 'Asia/Makassar',
                'title' => 'WITA',
                'description' => 'waktu indonesia bagian tengah (UTC+8)',
            ],
            [
                'locale' => 'Asia/Jayapura',
                'title' => 'WIT',
                'description' => 'waktu indonesia bagian timur (UTC+9)',
            ],
        ]);
    }
}
