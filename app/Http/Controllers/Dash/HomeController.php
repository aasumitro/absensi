<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('pages.home.index');
    }
}
