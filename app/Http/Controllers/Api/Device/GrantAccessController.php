<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\DeviceLoginRequest;
use App\Traits\ApiResponder;
use App\Traits\DeviceApiManager;
use Illuminate\Http\Response;

class GrantAccessController extends ApiController
{
    use ApiResponder, DeviceApiManager;

    public function index(DeviceLoginRequest $request)
    {
       if ($jwt = DeviceApiManager::login($request)) {
           $data = jwt_decode($jwt);

           return ApiResponder::success(
               [
                   'access' => [
                       'token' => $jwt,
                       'expires_in' => $data->exp,
                   ],
                   'session' => DeviceApiManager::generateSessionToken($jwt),
                   'branch_name' => $data->payload->department,
                   'device_name' => $data->payload->name,
                   'timezone' => [
                       'area' => $data->payload->timezone->area,
                       'locale' => $data->payload->timezone->locale,
                       'format' => $data->payload->timezone->format
                   ]
               ],
               strtoupper(SUCCESS_AUTHENTICATED_DESCRIPTION),
               Response::HTTP_CREATED
           );
       }

        return ApiResponder::error(
            strtoupper(FAILED_AUTHENTICATED_DESCRIPTION),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
