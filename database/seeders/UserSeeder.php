<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           [
               'role_id' => 1,
               'unique_id' => Str::uuid(),
               'telegram_id' => '585153765',
               'name' => 'A. A. Sumitro',
               'username' => 'aasumiro',
               'email' => 'hello@aasumitro.id',
               'phone' => '82271115593',
           ]
        ]);
    }
}
