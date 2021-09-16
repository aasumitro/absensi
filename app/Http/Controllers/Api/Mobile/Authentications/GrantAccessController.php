<?php

namespace App\Http\Controllers\Api\Mobile\Authentications;

use App\Actions\CreateAccessCodeAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\AuthGrantAccessRequest;
use App\Traits\ApiResponder;
use Illuminate\Http\Response;

class GrantAccessController extends ApiController
{
    use ApiResponder;

    public function index(AuthGrantAccessRequest $request, CreateAccessCodeAction $action)
    {
        try {
            $user = $action->execute($request->username);

            return ApiResponder::success(
                [
                    'id' => $user->id,
                    'uuid' => $user->unique_id,
                    'username' => $user->username
                ],
                'Successfully generate access code',
                Response::HTTP_CREATED
            );
        } catch (\Exception $exception) {
            return ApiResponder::error(
                $exception,
                Response::HTTP_SERVICE_UNAVAILABLE
            );
        }
    }
}
