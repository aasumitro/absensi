<?php

namespace App\Http\Controllers\Dash\Staff\Qrcode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrGeneratorController extends Controller
{
    public function __invoke()
    {
        return view('pages.staff.qrcode.generator.index');
    }
}
