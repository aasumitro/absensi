<?php

namespace App\Http\Filters\SubmissionParams;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\Params;

class UserParamImpl implements Params
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
            $user = User::where('name', $value)->first();
            $selected_id = $user->id;
        }

        return $builder->where('user_id', $selected_id);
    }
}
