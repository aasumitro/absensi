<?php

namespace App\Traits;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

trait DeviceApiManager
{
    protected function credentials(Request $request): array
    {
        return $request->only('unique_id', 'password');
    }

    public function login(Request $request)
    {
        return Auth::guard('device-api')->setTTL(JWT_TTL_IN_MINUTE)->attempt(
            $this->credentials($request)
        );
    }

    public function generateSessionToken(string $token): array
    {
        $data = (object) JWTAuth::manager()
            ->getJWTProvider()
            ->decode($token);
        $new_session_token = Str::random(32);

        $device = Device::where(
            "unique_id", $data->payload->unique_id
        )->firstOrFail();

        $device->session_token = $new_session_token;
        $device->save();

        return [
            'token' => $device->session_token,
            'refresh_time' => $device->refresh_time,
            'refresh_time_mode' => $device->refresh_time_mode
        ];
    }
}
