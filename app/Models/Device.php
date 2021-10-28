<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Device extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'unique_id',
        'device_id',
        'display',
        'name',
        'password',
        'refresh_time_mode',
        'refresh_time',
        'session_token',
        'latitude',
        'longitude'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            "payload" => [
                'department' => $this->department->name,
                'timezone' => [
                    'area' => $this->department->timezone->title,
                    'locale' => $this->department->timezone->locale,
                    'format' => $this->department->timezone->time_format
                ],
                'name' => $this->name,
                'unique_id' => $this->unique_id,
                'session_token' => $this->session_token,
                'refresh_time' => $this->refresh_time,
                'refresh_time_mode' => $this->refresh_time_mode,
            ]
        ];
    }
}
