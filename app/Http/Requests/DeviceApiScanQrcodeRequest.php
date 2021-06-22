<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceApiScanQrcodeRequest extends FormRequest
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
            'token' => 'required'
        ];
    }
}
