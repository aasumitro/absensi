<?php

namespace App\Http\Controllers\Api\Mobile\Authentications;

use App\Http\Controllers\Api\ApiController;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends ApiController
{
    use ApiResponder;

    public function index(Request $request)
    {
        JWTAuth::parseToken()->invalidate(
            $request->header('Authorization'));

        return ApiResponder::success(
            null,
            'Successfully [logged out]'
        );
    }
}
