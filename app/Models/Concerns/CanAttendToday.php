<?php

namespace App\Models\Concerns;

use App\Events\AttendEvent;
use App\Models\Attendance;
use App\Models\Device;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

trait CanAttendToday
{
    public function claimNewAttendance(string $mode, Request $request): array
    {
        if (!in_array($mode, $this::ACCEPTED_ATTENDANCE_CLAIM_MODE)) {
            throw new Exception("Mode tidak tersedia");
        }

        $attendance = $this->getAttendance();

        $device_id = null;
        if ($mode === $this::CLAIM_MODE_QRCODE) {
            $device = $this->getDevice($request->device_uid);
            $device_id = $device->id;

            // validasi session token yang dikirim dan device_session_token
            if (!$this->isSessionValid($request->session_token, $device->session_token)) {
                throw new Exception("QrCode tidak valid lagi, silahkan tekan tombol refresh pada layar perangkat!");
            }
        }

        if ($mode === $this::CLAIM_MODE_PICTURE) {
            $device = Device::where([
                'department_id' => auth()->user()->profile->department_id,
                'display' => 'DASHBOARD'
            ])->first();
            $device_id = $device->id;


            // TODO UPLOAD FILE AND SET ATTACHMENT
        }

        $current_session_time = $this->getSessionTime();

        // validasi presensi hari ini sudah ada apa belum
        // TODO: jika belum ada buat baru untuk attend masuk dengan ketentuan attend masuk:
        if (!$attendance) {
            $status = $this->isUserCanClaim($current_session_time);

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
            ];

            // if ($mode === $this::CLAIM_MODE_PICTURE) {
                // $payload['attachment_id'] = $attachment->id;
            // }

            return $this->attendIn($payload);
        }

        // TODO: jika sudah ada buat baru untuk attend pulang dengan ketentuan attend pulang:
        // jika belum cek sudah jam pulang atau belum
        if ($this->isCanGoHome($current_session_time, $attendance)) {
            // jika belum kasi notifikasi anda sudah absen datang kembali pukul sekian untuk absen pualng
            throw new Exception(
                "Anda sudah melakukan absensi datang silahkan ".
                "kembali pukul {$current_session_time['min_att_out']['time']} untuk absensi pulang"
            );
        }

        // cek dulu sudah absensi pulang atau belum
        if ($this->isCantAttendOut($attendance)) {
            // jika sudah absensi pulang kirim pesan sudah absen datang dan pulang
            throw new Exception("Hari ini Anda sudah melakukan absensi datang dan pulang");
        }

        // jika sudah masuk sessi absensi pulang dan belum absen pulang
        // update data absensi pulang dan kirim notifikasi
        return $this->attendOut($current_session_time, $attendance);
    }

    private function attendIn($payload): array
    {
        $message = "Anda berhasil melakukan absensi MASUK pada {$payload['datetime_in']}";

        $attendance = Attendance::create($payload);

        if (!$attendance) {
            throw new Exception("Gagal melakukan absensi masuk pada {$payload['datetime_in']}");
        }

        event(new AttendEvent(auth()->user(), $message));

        return ['action' => $message];
    }

    private function attendOut($session_time, Attendance $attendance): array
    {
        $message = "Anda berhasil melakukan absensi Pulang pada {$session_time['current_locale_time']['datetime']}";
        $attendance->datetime_out = $session_time['current_locale_time']['datetime'];
        $attendance->timestamp_out = $session_time['current_locale_time']['timestamp'];
        $attendance->save();

        event(new AttendEvent(auth()->user(), $message));

        return ['action' => $message];
    }

    private function isUserCanClaim(array $session_time): int
    {
        // validasi sudah bisa absen masuk atau tidak (min_att_acc)
        if (!$this->isSessionOpen($session_time)) {
            throw new Exception(
                "Gagal melakukan absensi, ".
                "sesi absensi masuk akan dibuka mulai pukul: " .
                "{$session_time['min_att_acc']['time']}"
            );
        }

        // validasi masih bisa absen masuk atau tidak (max_att_acc)
        if (!$this->isOverdueSessionEnd($session_time)) {
            throw new Exception(
                "Sesi absensi sudah ditutup, " .
                "Anda hanya bisa melakukan absensi dari pukul " .
                "{$session_time['min_att_acc']['time']} pagi - {$session_time['max_att_acc']['time']} pagi, " .
                "dimana diatas pukul {$session_time['max_att_in']['time']} dihitung terlambat."
            );
        }

        // validasi status terlambat atau tidak (current_attendance_status)
        return $this->isOverdue($session_time) ? 1 : 0;
    }

    private function isSessionValid($session_from_user, $device_session): bool
    {
        return $session_from_user === $device_session;
    }

    private function isSessionOpen(array $session_time): bool
    {
        return (bool)compare_time_greater_than(
            $session_time['current_locale_time']['time'],
            $session_time['min_att_acc']['time'],
        );
    }

    private function isOverdueSessionEnd(array $session_time): bool
    {
        return (bool)compare_time_less_than(
            $session_time['current_locale_time']['time'],
            $session_time['max_att_acc']['time'],
        );
    }

    private function isOverdue(array $session_time): bool
    {
        return (bool)compare_time_greater_than(
            $session_time['current_locale_time']['time'],
            $session_time['max_att_in']['time'],
        );
    }

    private function isCanGoHome(array $session_time, Attendance $attendance): bool
    {
        return (compare_time_less_than(
                $session_time['current_locale_time']['time'],
                $session_time['min_att_out']['time']
            ) && (
                $attendance->datetime_out === null &&
                $attendance->timestamp_out === null
            ));
    }

    private function isCantAttendOut(Attendance $attendance): bool
    {
        return ($attendance->datetime_out !== null && $attendance->timestamp_out !== null);
    }

    private function getAttendance()
    {
        return Attendance::where([
            'user_id' => auth()->id(),
            'date' => Carbon::now($this->profile->department->timezone->locale)
                ->format('Y-m-d')
        ])->first();
    }

    private function getDevice($device_unique_id)
    {
        return Device::where(
            'unique_id',
            $device_unique_id
        )->firstOr(function () use ($device_unique_id) {
            throw new Exception("QrCode dari perangkat ini tidak valid, silahkan hubungi admin!");
        });
    }

    private function getSessionTime(): array
    {
        // TODO change $now
        // $now = Carbon::now($this->profile->department->timezone->locale);
        $now = Carbon::parse("2021-10-25 16:31", $this->profile->department->timezone->locale);
        $max_att_in = Carbon::parse("{$now->format('Y-m-d')} {$this->profile->department->max_att_in}");
        $min_att_out = Carbon::parse("{$now->format('Y-m-d')} {$this->profile->department->min_att_out}");
        $min_att_acc = Carbon::parse($max_att_in->format('Y-m-d H:i'))
            ->subMinutes($this->profile->department->min_att_acc);
        $max_att_acc = Carbon::parse($max_att_in->format('Y-m-d H:i'))
            ->addMinutes($this->profile->department->max_att_acc);

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
                'minute_total' => $this->profile->department->min_att_acc
            ],
            'max_att_acc' => [
                'datetime' => $max_att_acc->format('Y-m-d H:i:s'),
                'date' => $max_att_acc->format('Y-m-d'),
                'time' => $max_att_acc->format('H:i'),
                'minute_total' => $this->profile->department->max_att_acc
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
