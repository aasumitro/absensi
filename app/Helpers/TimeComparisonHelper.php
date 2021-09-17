<?php

if (! function_exists('compare_time_equal'))
{
    function compare_time_equal($time_from_user, $time_from_system): string
    {
        return (strtotime($time_from_user) === strtotime($time_from_system));
    }
}

if (! function_exists('compare_time_less_than'))
{
    function compare_time_less_than($time_from_user, $time_from_setting): string
    {
        return (strtotime($time_from_user) <= strtotime($time_from_setting));
    }
}

if (! function_exists('compare_time_greater_than'))
{
    function compare_time_greater_than($time_from_user, $time_from_setting): string
    {
        return (strtotime($time_from_user) >= strtotime($time_from_setting));
    }
}

if (! function_exists('current_attendance_status'))
{
    function current_attendance_status($time_from_user, $time_from_setting): int
    {
        if (compare_time_less_than($time_from_user, $time_from_setting)) {
            return 0;
        }

        return 1;
    }
}
