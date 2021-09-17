<?php

namespace App\Http\Controllers\Api\Mobile\Profiles;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\ProfileUpdateFCMTokenRequest;
use App\Models\Managers\AccountManager;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class UpdateFCMTokenController extends ApiController
{
    use ApiResponder, AccountManager;

    public function index(ProfileUpdateFCMTokenRequest $request)
    {
        try {
            $this->modifyFCMToken($request->fcm_token);

            return ApiResponder::success(
                auth()->user()->fcm_token,
                "Successfully [resource updated]",
                Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            return ApiResponder::error(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
