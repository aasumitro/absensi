<?php

namespace App\Models\Concerns;

use App\Events\AttendEvent;
use App\Exceptions\Attendances\CouldNotClaimAttendance;
use App\Models\Attendance;
use App\Models\Device;
use App\Models\Managers\AttachmentManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

trait CanAttendToday
{
    use AttachmentManager;

    /**
     * @throws CouldNotClaimAttendance
     */
    public function claimNewAttendance(string $mode, Request $request): array
    {
        if (!in_array($mode, Attendance::ACCEPTED_ATTENDANCE_CLAIM_MODE)) {
            throw CouldNotClaimAttendance::couldNotAcceptMode();
        }

        $attendance = $this->getAttendance();

        $device_id = null;
        if ($mode === Attendance::CLAIM_MODE_QRCODE) {
            $device = $this->getDevice($request->device_uid);
            $device_id = $device->id ?? null;

            // validasi session token yang dikirim dan device_session_token
            if (!$this->isSessionValid($request->session_token, $device->session_token)) {
                throw CouldNotClaimAttendance::invalidQrCodeSession();
            }
        }

        $current_session_time = $this->getSessionTime();

        // validasi presensi hari ini sudah ada apa belum
        // TODO: jika belum ada buat baru untuk attend masuk dengan ketentuan attend masuk:
        if (!$attendance) {
            $status = $this->isUserCanClaim($current_session_time);

             if ($mode === Attendance::CLAIM_MODE_PICTURE) {
                 $device_id = Device::where([
                     'department_id' => auth()->user()->profile->department_id,
                     'display' => 'DASHBOARD'
                 ])->first()->id ?? null;

                 if (in_array(substr($request->file->extension(), -3), ['jpg','png','jpeg'])) {
                     $attachment_id = $this->createNewAttachment($request->file)->id;
                 }
             }

            $payload = [
                'user_id' => auth()->id(),
                'device_id' => $device_id,
                'department_id' => auth()->user()->profile->department_id,
                'type' => $mode,
                'status' => "ATTEND",
                'overdue' => $status,
                'date' => $current_session_time['current_locale_time']['date'],
                'datetime_in' => $current_session_time['current_locale_time']['datetime'],
                'timestamp_in' => $current_session_time['current_locale_time']['timestamp'],
                'latitude' => $request->latitude ?? null,
                'longitude' => $request->longitude ?? null,
                'attachment_id' => $attachment_id ?? null
            ];

            return $this->attendIn($payload);
        }

        // TODO: jika sudah ada buat baru untuk attend pulang dengan ketentuan attend pulang:
        // jika belum cek sudah jam pulang atau belum
        if ($this->isCanGoHome($current_session_time, $attendance)) {
            // jika belum kasi notifikasi anda sudah absen datang kembali pukul sekian untuk absen pualng
            throw CouldNotClaimAttendance::userHasAttendIn($current_session_time['min_att_out']['time']);
        }

        // cek dulu sudah absensi pulang atau belum
        if ($this->isCantAttendOut($attendance)) {
            // jika sudah absensi pulang kirim pesan sudah absen datang dan pulang
            throw CouldNotClaimAttendance::userHasAttend();
        }

        // jika sudah masuk sessi absensi pulang dan belum absen pulang
        // update data absensi pulang dan kirim notifikasi
        return $this->attendOut(
            $current_session_time,
            $attendance,
            (($mode === Attendance::CLAIM_MODE_PICTURE) ? $request->file : null)
        );
    }

    public function attendIn($payload, $user = null): array
    {
        $message = "Anda berhasil melakukan absensi MASUK pada {$payload['datetime_in']}";

        $attendance = Attendance::create($payload);

        if (!$attendance) {
            throw CouldNotClaimAttendance::failedCreateNewAttendance($payload['datetime_in']);
        }

        event(new AttendEvent($user ?? auth()->user(), $message));

        return ['action' => $message];
    }

    public function attendOut($session_time, Attendance $attendance, UploadedFile $file = null, $user = null): array
    {
        $message = "Anda berhasil melakukan absensi Pulang pada {$session_time['current_locale_time']['datetime']}";

        if ($file && in_array(substr($file->extension(), -3), ['jpg','png','jpeg'])) {
            $attachment_id = $this->createNewAttachment($file)->id;
            $attendance->attachment_out_id = $attachment_id ?? null;
        }

        $attendance->datetime_out = $session_time['current_locale_time']['datetime'];
        $attendance->timestamp_out = $session_time['current_locale_time']['timestamp'];
        $attendance->save();

        event(new AttendEvent($user ?? auth()->user(), $message));

        return ['action' => $message];
    }

    public function isUserCanClaim(array $session_time): int
    {
        // validasi sudah bisa absen masuk atau tidak (min_att_acc)
        if (!$this->isSessionOpen($session_time)) {
            throw CouldNotClaimAttendance::sessionNotYetOpened($session_time['min_att_acc']['time']);
        }

        // validasi masih bisa absen masuk atau tidak (max_att_acc)
        if (!$this->isOverdueSessionEnd($session_time)) {
            throw CouldNotClaimAttendance::sessionClosed(
                $session_time['min_att_acc']['time'],
                $session_time['max_att_acc']['time'],
                $session_time['max_att_acc']['time']
            );
        }

        // validasi status terlambat atau tidak (current_attendance_status)
        return $this->isOverdue($session_time) ? 1 : 0;
    }

    public function isSessionValid($session_from_user, $device_session): bool
    {
        return $session_from_user === $device_session;
    }

    public function isSessionOpen(array $session_time): bool
    {
        return (bool)compare_time_greater_than(
            $session_time['current_locale_time']['time'],
            $session_time['min_att_acc']['time'],
        );
    }

    public function isOverdueSessionEnd(array $session_time): bool
    {
        return (bool)compare_time_less_than(
            $session_time['current_locale_time']['time'],
            $session_time['max_att_acc']['time'],
        );
    }

    public function isOverdue(array $session_time): bool
    {
        return (bool)compare_time_greater_than(
            $session_time['current_locale_time']['time'],
            $session_time['max_att_in']['time'],
        );
    }

    public function isCanGoHome(array $session_time, Attendance $attendance): bool
    {
        return (compare_time_less_than(
                $session_time['current_locale_time']['time'],
                $session_time['min_att_out']['time']
            ) && (
                $attendance->datetime_out === null &&
                $attendance->timestamp_out === null
            ));
    }

    public function isCantAttendOut(Attendance $attendance): bool
    {
        return ($attendance->datetime_out !== null && $attendance->timestamp_out !== null);
    }

    public function getAttendance($user_id = null, $timezone = null)
    {
        return Attendance::where([
            'user_id' => $user_id ?? auth()->id(),
            'date' => Carbon::now($timezone ?? $this->profile->department->timezone->locale)
                ->format('Y-m-d')
        ])->latest('date')->first();
    }

    public function getDevice($device_unique_id)
    {
        return Device::where(
            'unique_id',
            $device_unique_id
        )->firstOr(function () use ($device_unique_id) {
            throw CouldNotClaimAttendance::invalidDeviceCredentials();
        });
    }

    public function createNewAttachment(UploadedFile $file)
    {
        return $this->newAttachment([
            'type' => 'IMAGE',
            'file'=> $file
        ], 'PRIVATE') ?? null;
    }

    public function getSessionTime($profile = null): array
    {
        $profile = $profile ?? $this->profile;
        // TODO change $now
        $now = Carbon::now($profile->department->timezone->locale);
        //$now = Carbon::parse("2021-11-01 16:31", $profile->department->timezone->locale);
        $max_att_in = Carbon::parse("{$now->format('Y-m-d')} {$profile->department->max_att_in}");
        $min_att_out = Carbon::parse("{$now->format('Y-m-d')} {$profile->department->min_att_out}");
        $min_att_acc = Carbon::parse($max_att_in->format('Y-m-d H:i'))
            ->subMinutes($profile->department->min_att_acc);
        $max_att_acc = Carbon::parse($max_att_in->format('Y-m-d H:i'))
            ->addMinutes($profile->department->max_att_acc);

        return [
            'max_att_in' => [
                'datetime' => $max_att_in->format('Y-m-d H:i:s'),
                'date' => $max_att_in->format('Y-m-d'),
                'time' => $max_att_in->format('H:i'),
            ],
            'min_att_out' => [
                'datetime' => $min_att_out->format('Y-m-d H:i:s'),
                'date' => $min_att_out->format('Y-m-d'),
                'time' => $min_att_out->format('H:i'),
            ],
            'min_att_acc' => [
                'datetime' => $min_att_acc->format('Y-m-d H:i:s'),
                'date' => $min_att_acc->format('Y-m-d'),
                'time' => $min_att_acc->format('H:i'),
                'minute_total' => $profile->department->min_att_acc
            ],
            'max_att_acc' => [
                'datetime' => $max_att_acc->format('Y-m-d H:i:s'),
                'date' => $max_att_acc->format('Y-m-d'),
                'time' => $max_att_acc->format('H:i'),
                'minute_total' => $profile->department->max_att_acc
            ],
            'current_locale_time' => [
                'datetime' => $now->format('Y-m-d H:i:s'),
                'date' => $now->format('Y-m-d'),
                'time' => $now->format('H:i'),
                'timestamp' => $now->timestamp,
            ]
        ];
    }
}
