<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
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
               'username' => 'aasumitro',
               'email' => 'aasumitro@gmail.com',
               'phone' => '82271115593',
               'attend_token' => \Hash::make('secret'),
               'attend_token_expiry' => Carbon::now()->addDays(10)
           ]
        ]);

        $user_id = DB::getPdo()->lastInsertId();

        DB::table('profiles')->insert([
           [
               'user_id' => $user_id,
               'department_id' => 2
           ]
        ]);
    }
}
