<?php

namespace App\Http\Controllers\Dash\Root\Offices;

use App\Http\Controllers\Controller;

class PeopleController extends Controller
{
    public function index()
    {
        return view('pages.root.offices.people.index');
    }
}
