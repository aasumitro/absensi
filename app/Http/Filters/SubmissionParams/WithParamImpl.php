<?php


namespace App\Http\Filters\SubmissionParams;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;

class WithParamImpl implements Params
{
    const ABSENT_TYPE_RELATION = 'absent_type';

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
            if ($relation === self::ABSENT_TYPE_RELATION) {
                $builder = $builder->with("absentType");
            }
        }

        return $builder;
    }
}
