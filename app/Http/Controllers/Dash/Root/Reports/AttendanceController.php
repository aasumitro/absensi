<?php

namespace App\Http\Controllers\Dash\Root\Reports;

use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('pages.root.reports.attendance.index');
    }
}
