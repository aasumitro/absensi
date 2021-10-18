<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AttendanceByPeopleExport implements WithColumnFormatting, WithHeadings, WithMapping, FromArray
{
    use Exportable;

    private $attendance;

    public function __construct($attendance)
    {
        $this->attendance = $attendance;
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER, // iteration
            'B' => NumberFormat::FORMAT_TEXT, // day Senin, selasa . . .
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY, // date attend 12-10-2021
            'D' => NumberFormat::FORMAT_TEXT, // Attend/Absent if Absent + AbsentType
            'E' => NumberFormat::FORMAT_DATE_TIME4, // time in 08:00:00
            'F' => NumberFormat::FORMAT_DATE_TIME4, // time out 16:00:00
            'G' => NumberFormat::FORMAT_TEXT, // overdue YA/TIDAK
            'H' => NumberFormat::FORMAT_TEXT,  // overtime YA/TIDAK
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Nama',
            'SKPD',
            'Hari',
            'Tanggal',
            'Status',
            'Masuk',
            'Keluar',
            'Terlambat',
            'Lembur',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance['iteration'],
            $attendance['name'],
            $attendance['department'],
            $attendance['day'],
            $attendance['date'],
            $attendance['status'],
            $attendance['datetime_in'],
            $attendance['datetime_in'],
            $attendance['overdue'],
            $attendance['overtime']
        ];
    }

    public function array(): array
    {
        return $this->attendance;
    }
}
