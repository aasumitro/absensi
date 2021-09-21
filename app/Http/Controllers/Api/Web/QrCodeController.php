<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\DeviceScanQrcodeRequest;
use App\Models\Device;
use App\Traits\DeviceApiManager;
use Illuminate\Support\Str;

class QrCodeController extends ApiController
{
    use DeviceApiManager;

    public function stream(): \Illuminate\Http\JsonResponse
    {
        $device = Device::where([
            'department_id' => auth()->user()->profile->department_id,
            'display' => 'DASHBOARD'
        ])->firstOrFail();
        $device->session_token = Str::random(32);
        $device->save();

        return response()
            ->json($device)
            ->header('Content-Type', 'application/json');
    }

    public function scan(DeviceScanQrcodeRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($this->attendUserByToken($request)) {
            return response()
                ->json($this->getCurrentMessage(), 201)
                ->header('Content-Type', 'application/json');
        }

        return response()
            ->json('ATTEND_FAILED', 403)
            ->header('Content-Type', 'application/json');
    }
}
