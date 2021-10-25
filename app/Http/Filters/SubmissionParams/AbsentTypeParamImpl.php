<?php

namespace App\Http\Filters\SubmissionParams;

use App\Models\AbsentType;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;

class AbsentTypeParamImpl implements Params
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
        if ($value === Params::ALL) return $builder;

        if (!in_array($value, params::AVAILABLE_ABSENT_TYPE)) return $builder;

        $absent_type = AbsentType::where('name', $value)->first();

        return $builder->where('absent_type_id', $absent_type->id);
    }
}
