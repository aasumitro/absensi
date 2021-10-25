<?php

namespace App\Http\Filters\AttendanceParams;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;

class LimitParamImpl implements Params
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
        return $builder->limit($value);
    }
}
