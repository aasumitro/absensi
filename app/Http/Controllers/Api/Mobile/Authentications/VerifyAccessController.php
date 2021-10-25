<?php

namespace App\Http\Controllers\Api\Mobile\Authentications;

use App\Actions\ValidateAccessCodeAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\AuthVerifyAccessRequest;
use App\Traits\ApiResponder;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class VerifyAccessController extends ApiController
{
    use ApiResponder;

    public function index(AuthVerifyAccessRequest $request, ValidateAccessCodeAction $action)
    {
        try {
            $data = $action->execute($request);

            return ApiResponder::success(
                $data,
                "Successfully [logged in]",
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return ApiResponder::error(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
