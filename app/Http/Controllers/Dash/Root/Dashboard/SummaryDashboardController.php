<?php

namespace App\Http\Controllers\Dash\Root\Dashboard;

use App\Http\Controllers\Controller;

class SummaryDashboardController extends Controller
{
    public function __invoke()
    {
        return view('pages.root.dashboard.summary.index');
    }
}
