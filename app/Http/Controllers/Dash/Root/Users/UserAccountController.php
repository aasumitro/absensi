<?php

namespace App\Http\Controllers\Dash\Root\Users;

use App\Http\Controllers\Controller;

class UserAccountController extends Controller
{
    public function __invoke()
    {
        return view('pages.root.users.accounts.index');
    }
}
