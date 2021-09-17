<?php

namespace App\Http\Controllers\Api\Mobile\Profiles;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\ProfileUpdateTelegramIdRequest;
use App\Models\Managers\AccountManager;
use App\Traits\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class UpdateTelegramIDController extends ApiController
{
    use ApiResponder, AccountManager;

    public function index(ProfileUpdateTelegramIdRequest $request)
    {
        try {
            $this->modifyTelegramId($request->telegram_id);

            return ApiResponder::success(
                auth()->user()->telegram_id,
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
