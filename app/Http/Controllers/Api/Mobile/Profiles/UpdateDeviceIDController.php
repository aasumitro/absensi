<?php

namespace App\Http\Controllers\Api\Mobile\Profiles;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\ProfileUpdateDeviceIdRequest;
use App\Models\Managers\AccountManager;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class UpdateDeviceIDController extends ApiController
{
    use ApiResponder, AccountManager;

    public function index(ProfileUpdateDeviceIdRequest $request)
    {
        try {
            $this->modifyPhoneId($request->phone_id);

            return ApiResponder::success(
                auth()->user()->phone_id,
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
