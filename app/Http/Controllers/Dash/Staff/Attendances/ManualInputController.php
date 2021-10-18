<?php

namespace App\Http\Controllers\Dash\Staff\Attendances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManualInputController extends Controller
{
    public function __invoke()
    {
        return view('pages.staff.attendance.input.index');
    }
}
