<?php

namespace App\Http\Controllers\Api\Mobile\Authentications;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\AuthApiGrantRequest;

class GrantAccessController extends ApiController
{
    public function index(AuthApiGrantRequest $request)
    {
        dd($request);
    }
}
