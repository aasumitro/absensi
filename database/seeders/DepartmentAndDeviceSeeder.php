<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DepartmentAndDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            DB::table('departments')->insert($data);
            $department_id = DB::getPdo()->lastInsertId();
            DB::table('devices')->insert([
                'department_id' => $department_id,
                'display' => 'DASHBOARD',
                'name' => "[{$data['name']}] default",
                'unique_id' => Str::uuid(),
                'password' => Hash::make('secret'),
                'session_token' => Str::random(32)
            ]);

            if ($department_id == 1) {
                DB::table('devices')->insert([
                    'department_id' => $department_id,
                    'display' => 'DEVICE',
                    'name' => "[RASPY01] KANTOR LT.3",
                    'unique_id' => "8af9cea5-d496-466c-a086-47be13c8b8dd",
                    'password' => Hash::make('secret'),
                    'session_token' => Str::random(32)
                ]);
            }
        }
    }

    private function data(): array
    {
        return [
          ['name' => 'Biro Administrasi Pimpinan'],
          ['name' => 'Biro Umum'],
          ['name' => 'Biro Pemerintahan'],
          ['name' => 'Biro Organisasi'],
          ['name' => 'Biro Kesejahteraan Rakyat'],
          ['name' => 'Biro Barang & Jasa'],
          ['name' => 'Biro Perekonomian'],
        ];
    }
}
