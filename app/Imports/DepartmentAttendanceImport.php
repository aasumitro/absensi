<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DepartmentAttendanceImport implements ToCollection
{
    private $data = [];

    public function collection(Collection $collection)
    {
        foreach ($collection as $item) {
            if ($item[0] !== 'NOMOR') {
                $user = User::select('id', 'name', 'username')
                    ->where('username', $item[1])
                    ->first() ?? "NOT_FOUND#$item[1]";

                $this->data[] = [
                    'username' => $user,
                    'date' => Date::excelToDateTimeObject($item[2])->format('Y-m-d'),
                    'time_in' => Date::excelToDateTimeObject($item[3])->format('H:i'),
                    'time_out' => Date::excelToDateTimeObject($item[4])->format('H:i'),
                    'overdue' => $item[5],
                    'overtime' => $item[6],
                ];
            }
        }
    }

    public function getData(): array
    {
        return $this->data;
    }
}
