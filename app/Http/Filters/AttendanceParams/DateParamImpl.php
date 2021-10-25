<?php

namespace App\Http\Filters\AttendanceParams;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;
use Illuminate\Support\Carbon;

class DateParamImpl implements Params
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value): Builder
    {
        $date = Carbon::createFromFormat('Y-m-d', $value);

        return $builder->where('date',  $date->format('Y-m-d'));
    }
}
