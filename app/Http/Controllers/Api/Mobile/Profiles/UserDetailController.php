<?php

namespace App\Http\Controllers\Api\Mobile\Profiles;

use App\Http\Controllers\Api\ApiController;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class UserDetailController extends ApiController
{
    use ApiResponder;

    public function index()
    {
        $user = auth()->user();
        $user['role'] = $user->role;
        $user['profile'] = $user->profile->department;

        return ApiResponder::success(
            $user,
            'Successfully [GET] Profile Detail',
            Response::HTTP_OK
        );
    }
}
