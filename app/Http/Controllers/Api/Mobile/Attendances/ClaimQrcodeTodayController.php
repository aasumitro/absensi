<?php

namespace App\Http\Controllers\Api\Mobile\Attendances;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\ClaimNewAttendanceByQrCodeRequest;
use App\Models\User;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class ClaimQrcodeTodayController extends ApiController
{
    public $mode = 'QRCODE';

    public function index(ClaimNewAttendanceByQrCodeRequest $request)
    {
        try {
            $callback = auth()->user()
                ->claimNewAttendance(
                    User::CLAIM_MODE_QRCODE,
                    $request);

            return ApiResponder::success(
                $callback['action'],
                "Successfully [attendance]",
                Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            return ApiResponder::error(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
