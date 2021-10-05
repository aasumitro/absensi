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

        $selected_id = $value;

        if (is_string($value)) {
            $absent_type = AbsentType::where('name', $value)->first();
            $selected_id = $absent_type->id;
        }

        return $builder->where('absent_type_id', $selected_id);
    }
}
