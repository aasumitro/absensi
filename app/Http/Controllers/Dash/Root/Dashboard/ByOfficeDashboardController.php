<?php

namespace App\Http\Controllers\Dash\Root\Dashboard;

use App\Http\Controllers\Controller;

class ByOfficeDashboardController extends Controller
{
    public function __invoke()
    {
        return view('pages.root.dashboard.scope-office.index');
    }
}
