<?php

namespace App\Http\Controllers\Dash\Root\Offices;

use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function __invoke()
    {
        return view('pages.root.offices.department.index');
    }
}
