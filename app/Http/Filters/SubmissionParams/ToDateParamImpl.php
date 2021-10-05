<?php

namespace App\Http\Filters\SubmissionParams;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;
use Carbon\Carbon;

class ToDateParamImpl implements Params
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return bool|Builder
     */
    public static function apply(Builder $builder, $value)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value);

        return $builder->where('created_at', '<=',  $date->format('Y-m-d 23:59:59'));
    }
}
