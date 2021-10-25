<?php

namespace App\Http\Filters;

class AttendanceFilter
{
    use Filters;

    public static function filterParams(): string
    {
        return 'AttendanceParams';
    }
}
