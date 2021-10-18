<?php

namespace App\Http\Controllers\Dash\Root\Reports;

use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    public function __invoke()
    {
        return view('pages.root.reports.submission.index');
    }
}
