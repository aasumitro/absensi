<?php

namespace App\Http\Filters\SubmissionParams;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;

class StatusParamImpl implements Params
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
        if ($value === params::TRASHED) return $builder->onlyTrashed();

        if (in_array($value, params::AVAILABLE_SUBMISSION_STATUS)) {
            return $builder->where('status',  $value);
        }

        return $builder;
    }
}
