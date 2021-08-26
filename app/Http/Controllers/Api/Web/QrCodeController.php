<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\ApiController;
use App\Models\Device;
use Illuminate\Support\Str;

class QrCodeController extends ApiController
{
    public function stream(): \Illuminate\Http\JsonResponse
    {
        $device = Device::where([
            'department_id' => auth()->user()->profile->department_id,
            'display' => 'DASHBOARD'
        ])->firstOrFail();
        $device->session_token = Str::random(32);
        $device->save();

        return response()
            ->json($device, 200)
            ->header('Content-Type', 'application/json');
    }

    public function scan()
    {

    }
}
