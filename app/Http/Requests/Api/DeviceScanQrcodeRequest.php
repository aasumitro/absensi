<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DeviceScanQrcodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_uuid' => 'required|exists:users,unique_id',
            'device_uuid' => 'required|exists:devices,unique_id',
            'attend_token' => 'required'
        ];
    }
}
