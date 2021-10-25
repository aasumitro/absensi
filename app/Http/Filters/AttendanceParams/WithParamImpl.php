<?php

namespace App\Http\Filters\AttendanceParams;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;

class WithParamImpl implements Params
{
    const ATTACHMENT_RELATION = 'attachment';
    const DEVICE_RELATION = 'device';
    const ABSENT_TYPE_RELATION = 'absent_type';
    const DEPARTMENT_RELATION = 'department';

    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value): Builder
    {
        $with = explode(',', $value);

        foreach ($with as $relation) {
            if ($relation === self::ATTACHMENT_RELATION) {
                $builder = $builder->with("attachment");
            }

            if ($relation === self::ABSENT_TYPE_RELATION) {
                $builder = $builder->with("absentType");
            }

            if ($relation === self::DEVICE_RELATION) {
                $builder = $builder->with("device");
            }

            if ($relation === self::DEPARTMENT_RELATION) {
                $builder = $builder->with("department");
            }
        }

        return $builder;
    }
}
