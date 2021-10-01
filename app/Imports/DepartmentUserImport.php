<?php

namespace App\Imports;

use App\Models\Managers\AccountManager;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Validator;

class DepartmentUserImport implements ToCollection
{
    use AccountManager;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $department_id = auth()->user()->profile->department_id;

        Validator::make($collection->toArray(), [
            '*.1' => 'required',
            '*.2' => 'required',
            '*.3' => 'required|unique:users,username',
            '*.4' => 'required|unique:users,email',
            '*.5' => 'required|unique:users,phone',
        ])->validate();

        foreach ($collection as $row) {
            if ($row[0] !== 'NOMOR') {
                $this->newAccount([
                    'role' => MEMBER_ROLE_ID,
                    'department' => $department_id,
                    'as' => $row[1],
                    'name' => $row[2],
                    'username' => $row[3],
                    'email' => $row[4],
                    'phone' => (int)$row[5],
                ]);
            }
        }
    }
}
