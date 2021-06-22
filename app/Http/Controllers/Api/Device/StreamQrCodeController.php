<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Api\ApiController;
use App\Traits\ApiResponder;
use App\Traits\DeviceApiManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StreamQrCodeController extends ApiController
{
    use ApiResponder, DeviceApiManager;

    public function index(Request $request)
    {
        $token = DeviceApiManager::generateSessionToken($request);

        return ApiResponder::success(
            $token,
            'Successfully [device regenerate session]',
            Response::HTTP_CREATED
        );
    }
}
