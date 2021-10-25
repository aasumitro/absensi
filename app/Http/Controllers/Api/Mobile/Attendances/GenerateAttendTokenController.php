<?php

namespace App\Http\Controllers\Api\Mobile\Attendances;

use App\Http\Controllers\Api\ApiController;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class GenerateAttendTokenController extends ApiController
{
    use ApiResponder;

    public function index()
    {
        try {
            $token = auth()->user()->generateAttendToken();

            return ApiResponder::success(
                [
                    'token' => $token,
                    'expire' => [
                        'time_mode' => "MINUTE",
                        'time_value' => 10
                    ]
                ],
                "Successfully [generate attend token]",
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
