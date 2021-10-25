<?php

namespace App\Http\Filters\SubmissionParams;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;
use Carbon\Carbon;

class BetweenDateParamImpl implements Params
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
        $between = explode(',', $value);

        if (count($between) < 2) return $builder;

        $start = Carbon::createFromFormat('Y-m-d', $between[0]);
        $end = Carbon::createFromFormat('Y-m-d', $between[1]);

        return $builder->whereBetween('created_at',
            [
                $start->format('Y-m-d 00:00:00'),
                $end->format('Y-m-d 00:00:00'),
            ]
        );
    }
}
