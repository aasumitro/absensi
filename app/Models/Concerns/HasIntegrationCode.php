<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait HasIntegrationCode
{
    public function generateIntegrationCode(): string
    {
        $new_integration_code = Str::random(12);
        $this->integration_code = Hash::make($new_integration_code);
        $this->save();
        return $new_integration_code;
    }
}
