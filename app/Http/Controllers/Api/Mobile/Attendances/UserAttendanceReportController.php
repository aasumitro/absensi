<?php

namespace App\Http\Controllers\Api\Mobile\Attendances;

use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\AttendanceFilter;
use App\Models\Attendance;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAttendanceReportController extends ApiController
{
    use ApiResponder;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request (between_date, date, limit, status, with)
     * between_date format (2010-10-10,2010-10-20) impl (split with `,`)
     * date format (2010-10-10)
     * limit int (12)
     * status enum (ATTEND, ABSENT)
     * with relation (attachment, absent_type, device, department)
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        return ApiResponder::success(
            AttendanceFilter::apply(
                $request, (new Attendance)->newQuery()
            )->where('user_id', auth()->user()->id)
                ->latest('date')
                ->get(),
            "Successfully [GET] Attendance Report",
            Response::HTTP_OK
        );
    }
}
