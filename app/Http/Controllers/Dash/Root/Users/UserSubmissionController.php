<?php

namespace App\Http\Controllers\Dash\Root\Users;

use App\Http\Controllers\Controller;

class UserSubmissionController extends Controller
{
    public function index()
    {
        return view('pages.root.users.submissions.index');
    }
}
