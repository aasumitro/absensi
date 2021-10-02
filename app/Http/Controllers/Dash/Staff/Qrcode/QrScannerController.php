<?php

namespace App\Http\Controllers\Dash\Staff\Qrcode;

use App\Http\Controllers\Controller;
use App\Models\Device;

class QrScannerController extends Controller
{
    public function index()
    {
        $device_unique_id = Device::where([
            'department_id' => auth()->user()->profile->department_id,
            'display' => 'DASHBOARD',
        ])->first()->unique_id;

        return view('pages.staff.qrcode.scanner.index', compact('device_unique_id'));
    }
}
