<?php

namespace App\Http\Controllers\Dash\Root\Users\Accounts;

use App\Http\Controllers\Controller;

class UserAccountController extends Controller
{
    public function index()
    {
        return view('pages.root.users.accounts.index');
    }
}
