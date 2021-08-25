<?php

namespace App\Models;

use App\Models\People\Profiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

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
