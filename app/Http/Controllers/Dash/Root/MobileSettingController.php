<?php

namespace App\Http\Controllers\Dash\Root;

use App\Http\Controllers\Controller;
use App\Models\MobilePreference;
use Illuminate\Support\Facades\Cache;

class MobileSettingController extends Controller
{
    public function index()
    {
        return view('pages.root.settings.mobile.index');
    }
}
