<?php

namespace App\Http\Controllers\Dash\Staff\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function __invoke()
    {
        return view('pages.staff.admin.people.index');
    }
}
