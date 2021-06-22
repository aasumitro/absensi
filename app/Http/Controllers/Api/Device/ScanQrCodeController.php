<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\DeviceApiScanQrcodeRequest;
use App\Traits\ApiResponder;
use App\Traits\DeviceApiManager;
use Illuminate\Http\Request;

class ScanQrCodeController extends ApiController
{
    use ApiResponder, DeviceApiManager;

    public function index(DeviceApiScanQrcodeRequest $request)
    {
        $jwt = str_replace('Bearer ','', $request->header('authorization'));

        dd($jwt);

        // todo attendance
    }
}
