<?php

namespace App\Http\Controllers\Api\Mobile\Authentications;

use App\Actions\ValidateAccessCodeAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\AuthVerifyAccessRequest;
use App\Traits\ApiResponder;
use Illuminate\Http\Response;

class VerifyAccessController extends ApiController
{
    use ApiResponder;

    public function index(AuthVerifyAccessRequest $request, ValidateAccessCodeAction $action)
    {
        return ApiResponder::success(
            $action->execute($request),
            "Successfully [logged in]",
            Response::HTTP_CREATED
        );
    }
}
