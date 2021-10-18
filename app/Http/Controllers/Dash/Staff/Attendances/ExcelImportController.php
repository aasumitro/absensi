<?php

namespace App\Http\Controllers\Dash\Staff\Attendances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExcelImportController extends Controller
{
    public function __invoke()
    {
        return view('pages.staff.attendance.file.index');
    }
}
