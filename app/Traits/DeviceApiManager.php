<?php

namespace App\Traits;

use App\Events\AttendEvent;
use App\Exceptions\Attendances\CouldNotClaimAttendance;
use App\Models\Attendance;
use App\Models\Device;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait DeviceApiManager
{
    public static function login(Request $request)
    {
        $device = Device::where([
            'unique_id' => $request->unique_id
        ])->firstOrFail();

        if (!$device->device_id) {
            $device->device_id = $request->device_id;
            $device->save();
        }

        if ($device->device_id !== $request->device_id) {
            throw new \Exception("Sepertinya anda menggunakan data kredensial ini pada perangkat baru, segera hubungi admin untuk melakukan reset agar data kredensial bisa digunakan pada perangkat baru ini!");
        }

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

    /**
     * @throws CouldNotClaimAttendance
     */
    public function attendUserByToken(Request $request)
    {
        $user = $this->getUser($request->user_uuid, $request->attend_token);

        $attendance = $user->getAttendance($user->id, $user->profile->department->timezone->locale);

        $current_session_time = $user->getSessionTime($user->profile);

        if (!$attendance) {
            $status = $user->isUserCanClaim($current_session_time);

            $payload = [
                'user_id' => $user->id,
                'device_id' => $user->getDevice($request->device_uuid)->id,
                'department_id' => $user->profile->department_id,
                'type' => 'QRCODE_SCAN',
                'status' => "ATTEND",
                'overdue' => $status,
                'date' => $current_session_time['current_locale_time']['date'],
                'datetime_in' => $current_session_time['current_locale_time']['datetime'],
                'timestamp_in' => $current_session_time['current_locale_time']['timestamp'],
            ];

            return $user->attendIn($payload, $user);
        }

        if ($user->isCanGoHome($current_session_time, $attendance)) {
            // jika belum kasi notifikasi anda sudah absen datang kembali pukul sekian untuk absen pualng
            throw CouldNotClaimAttendance::userHasAttendIn($current_session_time['min_att_out']['time']);
        }

        // cek dulu sudah absensi pulang atau belum
        if ($user->isCantAttendOut($attendance)) {
            // jika sudah absensi pulang kirim pesan sudah absen datang dan pulang
            throw CouldNotClaimAttendance::userHasAttend();
        }

        return $user->attendOut(
            $current_session_time,
            $attendance,
            null,
            $user
        );
    }

    /**
     * @throws CouldNotClaimAttendance
     */
    private static function getUser($user_unique_id, $attend_token)
    {
        $user = User::where('unique_id', $user_unique_id)->firstOrFail();

        if (!$user->isAttendTokenValid($attend_token)) {
            throw CouldNotClaimAttendance::attendTokenNotValid();
        }

        return $user;
    }
}
