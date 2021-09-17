<?php

namespace App\Http\Controllers\Api\Mobile\Profiles;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\ProfileUpdateAvatarRequest;
use App\Models\Managers\AccountManager;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class UpdateProfilePictureController extends ApiController
{
    use ApiResponder, AccountManager;

    public function index(ProfileUpdateAvatarRequest $request)
    {
        try {
            $this->modifyAvatar($request);

            return ApiResponder::success(
                auth()->user()->avatar,
                "Successfully [resource uploaded]",
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
