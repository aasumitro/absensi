<?php

namespace App\Traits;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait DeviceApiManager
{
    public static function login(Request $request)
    {
        return Auth::guard('device-api')->setTTL(JWT_TTL_IN_MINUTE)->attempt(
            $request->only('unique_id', 'password')
        );
    }

    public static function generateSessionToken(string $jwt): array
    {
        $uuid = jwt_decode($jwt)->payload->unique_id;

        $device = Device::where("unique_id", $uuid)->firstOrFail();
        $device->session_token = Str::random(32);
        $device->save();

        return [
            'token' => $device->session_token,
            'refresh_time' => $device->refresh_time,
            'refresh_time_mode' => $device->refresh_time_mode
        ];
    }

    public static function attendUserByToken(Request $request): bool
    {
        $user = User::where('unique_id', $request->user_uuid)->firstOrFail();

        if (!$user->isAttendTokenValid($request->attend_token)) {
            return false;
        }

        // TODO
        // call event with queueable to generate user attendance
        // to sent notify via telegram and destroy attend_token

        return true;
    }
}
