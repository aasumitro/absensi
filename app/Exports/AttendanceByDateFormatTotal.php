<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceByDateFormatTotal implements
    FromView,
    ShouldAutoSize,
    WithStyles
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.reports.date.total', [
            'reports' => $this->data
        ]);
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'alignment' => array(
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ),
                'font' => [
                    'size' => 25,
                    'bold' => true
                ],
            ],
            4 => ['font' => ['bold' => true, 'italic' => true]],
            5 => ['font' => ['bold' => true, 'italic' => true]],
            6 => ['font' => ['bold' => true, 'italic' => true]],
        ];
    }
}
