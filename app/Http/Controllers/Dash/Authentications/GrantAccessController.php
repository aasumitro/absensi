<?php

namespace App\Http\Controllers\Dash\Authentications;

use App\Http\Controllers\Controller;
use App\Traits\Auth\AuthenticatesUsers;

class GrantAccessController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('pages.auth.index');
    }
}
