<?php

namespace App\Traits;

use App\Events\AttendEvent;
use App\Models\Attendance;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait DeviceApiManager
{
    protected string $current_message = "ATTEND_SUCCESS";

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

    public function attendUserByToken(Request $request): bool
    {
        $user = self::getUser($request->user_uuid, $request->attend_token);

        $device = self::getDevice($request->device_uuid);

        $attendance = self::getAttendance($user->id);

        $current_locale_time = get_locale_time($device->department->timezone->title);

        switch (true) {
            case (!$attendance):
                $notify_message = self::doAttendIn([
                    'user_id' => $user->id,
                    'device_id' => $device->id,
                    'department_id' => $device->department->id,
                    'type' => 'QRCODE_SCAN',
                    'status' => 'ATTEND',
                    'date' => $current_locale_time->date,
                    'datetime_in' => $current_locale_time->datetime,
                    'timestamp_in' => $current_locale_time->timestamp,
                    'overdue' => current_attendance_status(
                        $current_locale_time->time,
                        $device->department->max_att_in
                    ),
                ]);
                break;
            case ($this->isAttendOut($current_locale_time, $attendance, $device)):
                $notify_message = self::doAttendOut($attendance->id, [
                    'datetime_out' => $current_locale_time->datetime,
                    'timestamp_out' => $current_locale_time->timestamp,
                ]);
                break;
            default :
                ($attendance->datetime_out === null && $attendance->timestamp_out === null)
                    ? $notify_message = "Anda sudah melakukan absensi datang silahkan kembali pukul {$device->department->min_att_out} untuk absensi pulang"
                    : $notify_message = "Anda sudah melakukan absensi datang dan pulang";
                break;
        }

        self::sendNotify($user, $notify_message);

        $this->current_message = $notify_message;

        return true;
    }

    private static function getUser($user_unique_id, $attend_token)
    {
        $user = User::where('unique_id', $user_unique_id)->firstOrFail();

        if (!$user->isAttendTokenValid($attend_token)) {
            return false;
        }

        return $user;
    }

    private static function getDevice($device_unique_id): Device
    {
        return Cache::remember(
            "device_{$device_unique_id}",
            120,
            function() use ($device_unique_id)
        {
            return Device::where('unique_id', $device_unique_id)
                ->with('department')
                ->firstOrFail();
        });
    }

    private static function getAttendance($user_id)
    {
        return Attendance::where([
            'user_id' => $user_id,
            'date' => \Carbon\Carbon::now()->format('Y-m-d')
        ])->latest('date')->first();
    }

    protected static function doAttendIn($payload): string
    {
        $message = "Anda berhasil melakukan absensi Datang pada {$payload['datetime_in']}";

        $payload['created_at'] = $payload['datetime_in'];
        DB::table('attendances')->insert($payload);

        return $message;
    }

    protected static function doAttendOut($attendance_id, $payload): string
    {
        $message = "Anda berhasil melakukan absensi Pulang pada {$payload['datetime_out']}";

        $payload['updated_at'] = $payload['datetime_out'];
        DB::table('attendances')->where('id', $attendance_id)->update($payload);

        return  $message;
    }

    protected static function sendNotify(User $user, $message)
    {
        event(new AttendEvent($user, $message));
    }

    protected function getCurrentMessage(): string
    {
        return $this->current_message;
    }

    protected function isAttendOut($current_locale_time, $attendance, $device): bool
    {
        return (compare_time_greater_than(
                $current_locale_time->time,
                $device->department->min_att_out
            ) && $attendance->datetime_out === null
            && $attendance->timestamp_out === null);
    }
}
