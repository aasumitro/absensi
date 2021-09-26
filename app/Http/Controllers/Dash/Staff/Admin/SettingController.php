<?php

namespace App\Http\Controllers\Dash\Staff\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('pages.staff.admin.setting.index');
    }
}
