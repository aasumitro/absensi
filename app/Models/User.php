<?php

namespace App\Models;

use App\Models\People\ASN;
use App\Models\People\THL;
use App\Traits\User\HasOTP;
use App\Traits\User\HasRole;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static where(array $array)
 */
class User extends Authenticatable
{
    use Notifiable, HasRole, HasOTP;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'passwordless',
        'remember_token',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function detail(): ?HasOne
    {
        if ($this->as === 'PNS') {
            return $this->hasOne(ASN::class);
        }

        if ($this->as === 'THL') {
            return $this->hasOne(THL::class);
        }

        return null;
    }
}
