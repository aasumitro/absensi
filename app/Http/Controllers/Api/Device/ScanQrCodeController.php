<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\DeviceScanQrcodeRequest;
use App\Traits\ApiResponder;
use App\Traits\DeviceApiManager;
use Illuminate\Http\Response;
use Exception;

class ScanQrCodeController extends ApiController
{
    use ApiResponder, DeviceApiManager;

    public function index(DeviceScanQrcodeRequest $request)
    {
        try {
            $callback = $this->attendUserByToken($request);

            return ApiResponder::success(
                $callback['action'],
                'Successfully [attend user by token]',
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return ApiResponder::error(
                $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
