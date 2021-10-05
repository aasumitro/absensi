<?php

namespace App\Http\Filters\SubmissionParams;

use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;

class DepartmentParamImpl implements Params
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
        if ($value === params::ALL) return $builder;

        $selected_id = $value;

        if (is_string($value)) {
            $department = Department::where('name', $value)->first();
            $selected_id = $department->id;
        }

        return $builder->where('department_id', $selected_id);
    }
}
