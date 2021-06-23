<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobilePreference extends Model
{
    public function attachment(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }
}
