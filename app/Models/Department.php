<?php

namespace App\Models;

use App\Models\People\THL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
