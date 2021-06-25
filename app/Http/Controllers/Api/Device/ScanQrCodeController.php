<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\DeviceApiScanQrcodeRequest;
use App\Traits\ApiResponder;
use App\Traits\DeviceApiManager;
use Illuminate\Http\Response;

class ScanQrCodeController extends ApiController
{
    use ApiResponder, DeviceApiManager;

    public function index(DeviceApiScanQrcodeRequest $request)
    {
        if (DeviceApiManager::attendUserByToken($request)) {
            return ApiResponder::success(
                "ATTEND_SUCCESS",
                'Successfully [attend user by token]',
                Response::HTTP_CREATED
            );
        }

        return ApiResponder::error(
            "ATTEND_FAILED",
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
