<?php

namespace App\Http\Controllers\Dash\Root;

use App\Http\Controllers\Controller;

class MobileSettingController extends Controller
{
    public function __invoke()
    {
        return view('pages.root.settings.mobile.index');
    }
}
