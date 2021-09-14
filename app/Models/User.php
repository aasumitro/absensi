<?php

namespace App\Models;

use App\Models\Concerns\HasAttendToken;
use App\Models\Concerns\HasIntegrationCode;
use App\Models\Concerns\HasOneTimePassword;
use App\Models\Concerns\HasRole;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRole, HasOneTimePassword, HasAttendToken, HasIntegrationCode;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'unique_id',
        'fcm_token',
        'phone_id',
        'telegram_id',
        'as',
        'avatar',
        'name',
        'username',
        'email',
        'phone',
        'status',
        'passwordless',
        'passwordless_expiry',
        'attend_token',
        'attend_token_expiry'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'passwordless',
        'attend_token',
        'remember_token',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            "payload" => [
                'username' => $this->username,
                'phone_id' => $this->phone_id,
                'unique_id' => $this->unique_id,
            ]
        ];
    }
}
