<?php

namespace App\Http\Controllers\Dash\Staff\Qrcode;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Support\Facades\Cache;

class QrScannerController extends Controller
{
    public function __invoke()
    {
        $department_id = auth()->user()->profile->department_id;

        $device_unique_id = Cache::remember(
            "duid_dash_$department_id", 120,
            function () use ($department_id) {
                return Device::where([
                    'department_id' => $department_id,
                    'display' => 'DASHBOARD',
                ])->first()->unique_id;
            });

        return view('pages.staff.qrcode.scanner.index', compact('device_unique_id'));
    }
}
