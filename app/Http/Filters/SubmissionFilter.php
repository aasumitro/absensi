<?php

namespace App\Http\Filters;

class SubmissionFilter
{
    use Filters;

    public static function filterParams(): string
    {
        return 'SubmissionParams';
    }
}
