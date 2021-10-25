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

    /**
     * Display a listing of the resource.
     *
     * @param Request $request (between_date, date, limit, status, with)
     * absent_type format (string:name) impl: CT, SK
     * between_date format (2010-10-10,2010-10-20) impl (split with `,`)
     * status enum (ISSUED, ACCEPTED, REJECTED)
     * with relation (absent_type)
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        return ApiResponder::success(
            SubmissionFilter::apply(
                $request, (new Submission)->newQuery()
            )->where('user_id', auth()->user()->id)
                ->latest('created_at')
                ->get(),
            "Successfully [GET] Submission Report",
            Response::HTTP_OK
        );
    }
}
