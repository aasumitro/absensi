<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class);
    }
}
