<?php

namespace App\Http\Controllers\Dash\Authentications;

use App\Http\Controllers\Controller;

class GrantAccessController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')
            ->except('logout');
    }

    public function index()
    {
        return view('pages.auth.index');
    }
}
