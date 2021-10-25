<?php

namespace App\Http\Controllers\Api\Mobile\Submissions;

use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\SubmissionFilter;
use App\Models\Submission;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubmissionReportController extends ApiController
{
    use ApiResponder;

    public function index(Request $request)
    {
        return ApiResponder::success(
            SubmissionFilter::apply(
                $request, (new Submission)->newQuery()
            )->where('user_id', auth()->user()->id)
                ->latest('created_at')
                ->get(),
            "Successfully [GET] Attendance Report",
            Response::HTTP_OK
        );
    }
}
