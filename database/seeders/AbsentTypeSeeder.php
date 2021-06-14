<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('absent_types')->insert([
           ['name' => 'CT', 'description' => 'cuti'],
           ['name' => 'SIK', 'description' => 'sakit']
        ]);
    }
}
