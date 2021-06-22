<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\DeviceApiLoginRequest;
use App\Traits\ApiResponder;
use App\Traits\DeviceApiManager;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class GrantAccessController extends ApiController
{
    use ApiResponder, DeviceApiManager;

    public function index(DeviceApiLoginRequest $request)
    {
       if ($token = $this->login($request)) {
           $data = (object) JWTAuth::manager()->getJWTProvider()->decode($token);

           return ApiResponder::success(
               [
                   'access' => [
                       'token' => $token,
                       'expires_in' => $data->exp,
                   ],
                   'session' => $this->generateSessionToken($token),
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
