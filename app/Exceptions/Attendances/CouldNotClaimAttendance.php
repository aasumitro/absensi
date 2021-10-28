<?php

namespace App\Exceptions\Attendances;

use Exception;

class CouldNotClaimAttendance extends Exception
{
    public static function couldNotAcceptMode(): self
    {
        return new static("Mode yang dipilih tidak tersedia");
    }

    public static function invalidQrCodeSession(): self
    {
        return new static("QrCode tidak valid lagi, silahkan tekan tombol refresh pada layar perangkat!");
    }

    public static function userHasAttendIn(string $time): self
    {
        return new static("Anda sudah melakukan absensi datang silahkan kembali pukul $time untuk absensi pulang");
    }

    public static function userHasAttend(): self
    {
        return new static("Hari ini Anda sudah melakukan absensi datang dan pulang");
    }

    public static function failedCreateNewAttendance(string $datetime_in): self
    {
        return new static("Gagal melakukan absensi masuk pada $datetime_in");
    }

    public static function sessionNotYetOpened(string $time):self
    {
        return new static("Gagal melakukan absensi, sesi absensi masuk akan dibuka mulai pukul: $time");
    }

    public static function sessionClosed(string $open_session, string $close_session, string $max_session):self
    {
        return new static("Sesi absensi sudah ditutup, Anda hanya bisa melakukan absensi dari pukul $open_session pagi sampai $close_session pagi, dimana diatas pukul $max_session dihitung terlambat.");
    }

    public static function invalidDeviceCredentials():self
    {
        return new static("QrCode dari perangkat ini tidak valid, silahkan hubungi admin!");
    }
}
